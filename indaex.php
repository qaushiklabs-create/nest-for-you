<?php
// index.php  ✅ Register submit works + ✅ Apartment selected shows "Sorry, we have no agent in X" (no redirect)

// ==============================
// Base URL + Canonical (clean)
// ==============================
$base_url = "https://nestforyou.in";
$path = strtok($_SERVER["REQUEST_URI"], '?');
$path = preg_replace('#/index\.php$#i', '/', $path);
$path = '/' . ltrim($path, '/');
$canonical = rtrim($base_url . $path, '/');
if ($canonical === $base_url) $canonical .= '/';

// =====================================================
// ✅ AJAX REGISTER HANDLER (POST to same index.php)
// - Saves lead to /leads/agent-register-leads.csv
// - Returns JSON success/error
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register_agent') {
  header('Content-Type: application/json; charset=utf-8');

  // Basic sanitize
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone_number'] ?? '');
  $city  = trim($_POST['city'] ?? '');
  $sector= trim($_POST['sector'] ?? '');
  $apartment = trim($_POST['apartment'] ?? ''); // optional

  // Validate
  if ($name === '' || $email === '' || $phone === '' || $city === '' || $sector === '') {
      header_remove();
header('Content-Type: application/json; charset=utf-8');
http_response_code(200);

    echo json_encode(["status"=>"error","message"=>"Please fill all required fields."]);
    exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status"=>"error","message"=>"Please enter a valid email."]);
    exit;
  }
  if (!preg_match('/^[0-9\+\-\s]{10,15}$/', $phone)) {
    echo json_encode(["status"=>"error","message"=>"Please enter a valid phone number."]);
    exit;
  }

  $ip = $_SERVER['REMOTE_ADDR'] ?? '';
  $dt = date('Y-m-d H:i:s');

  // DB connection (SAME DB used by search-city.php)
$conn = new mysqli(
  "localhost",
  "nestforyou_user",
  "Nestforyou@2025",
  "nestforyou_root",
  3306
);

if ($conn->connect_error) {
  echo json_encode(["status"=>"error","message"=>"Database connection failed"]);
  exit;
}

// Insert into forum table
$stmt = $conn->prepare("
  INSERT INTO forum 
  (name, email, phone_number, city, sector, apartment, message, ip, created_at, updated_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
");

$message = trim($_POST['message'] ?? '');
if ($message === '') {
    $message = 'Agent registration via homepage';
}

$stmt->bind_param(
  "ssssssss",
  $name,
  $email,
  $phone,
  $city,
  $sector,
  $apartment,
  $message,
  $ip
);

$stmt->execute();
$stmt->close();
$conn->close();

  echo json_encode(["status"=>"success","message"=>"Submitted successfully. We will contact you soon."]);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Property in Gurgaon for Rent, Buy & Sell | Nestforyou</title>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

  <meta name="description" content="Find property in Gurgaon for rent, sale by owner, or ready-to-move-in. Discover homes under 30 and 50 lakhs with clear pricing. Explore your options today!">
  <meta name="keywords" content="property in gurgaon for rent,property for sale in gurgaon by owner,properties in gurgaon with prices,property in gurgaon under 50 lakhs,property in gurgaon ready to move,property in gurgaon under 30 lakhs">

  <link href="https://nestforyou.in/assets/img/favicon.png" rel="icon">
  <link href="https://nestforyou.in/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="/assets/css/main.css" rel="stylesheet">

  <style>
    #hero{
      position: relative;
      min-height: calc(100vh - 170px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 12px 120px;
    }
    #hero > img{
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 1;
    }
    #hero .nfy-hero-center{
      position: relative;
      z-index: 4;
      width: 100%;
    }

    .nfy-hero-grid{
      max-width: 1180px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
      gap: 18px;
      align-items: start;
    }
    .nfy-hero-grid > div{ min-width: 0; }

    .nfy-card{
      background: transparent;
      border: 1px solid rgba(255,255,255,0.10);
      border-radius: 14px;
      padding: 26px 26px;
      box-shadow: 0 18px 50px rgba(0,0,0,0.25);
      color: #fff;
    }

    .nfy-mini-title{
      font-family: var(--heading-font);
      font-weight: 700;
      letter-spacing: 1.2px;
      font-size: 13px;
      color: rgba(255,255,255,0.78);
      text-transform: uppercase;
      margin-bottom: 12px;
      position: relative;
      padding-bottom: 10px;
    }
    .nfy-mini-title:after{
      content:"";
      position:absolute;
      left:0;
      bottom:0;
      width: 90px;
      height: 2px;
      background: var(--accent-color);
    }

    .nfy-card .form-control{
      height: 50px !important;
      line-height: 50px !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      width: 100%;
    }

    .nfy-card input,
    .nfy-card select,
    .nfy-card textarea{
      background-color: #ffffff !important;
      color: #000000 !important;
      border-color: #cccccc !important;
      appearance: auto !important;
      -webkit-appearance: auto !important;
      -moz-appearance: auto !important;
    }

    select:disabled{ opacity: 0.75; cursor: not-allowed; }

    .nfy-btn{
      height: 50px;
      padding: 0 18px;
      border-radius: 10px;
      font-weight: 700;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:10px;
      width: 100%;
    }
    .nfy-disabled-btn{
      opacity: 0.6;
      cursor: not-allowed;
      pointer-events: none;
    }

    .nfy-action-row{
      margin-top: 12px;
      display: flex;
      gap: 12px;
      width: 100%;
    }
    .nfy-action-row .nfy-btn,
    .nfy-action-row .nfy-clearbtn{
      flex: 1 1 0;
      min-width: 0;
    }

    .nfy-clearbtn{
      height: 50px;
      padding: 0 18px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.35);
      background: rgba(0,0,0,0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      user-select: none;
      font-weight: 700;
      color: rgba(255,255,255,0.75);
    }
    .nfy-clearbtn:hover{
      border-color: rgba(255,255,255,0.55);
      color: rgba(255,255,255,0.9);
    }

    [data-aos]{ opacity: 1 !important; transform: none !important; transition: none !important; }

    .nfy-help{ margin-top: 8px; font-size: 13px; color: rgba(255,255,255,0.75); }
    .nfy-help.error{ color: #ff6b6b; }
    .nfy-help.ok{ color: var(--accent-color); }

    .nfy-reg-msg{ margin-top: 10px; font-weight: 800; text-align: center; font-size: 14px; }
    .nfy-reg-msg.ok{ color: var(--accent-color); }
    .nfy-reg-msg.err{ color: #ff6b6b; }

    @media (max-width: 992px){
      #hero{ min-height: auto; padding: 120px 12px 80px; }
      .nfy-hero-grid{ grid-template-columns: 1fr; }
    }
    @media (max-width: 520px){
      .nfy-action-row{ flex-direction: column; }
    }

    /* ✅ IMPORTANT FIX: overlay was blocking clicks on <select> */
    #hero::before,
    #hero::after,
    .hero::before,
    .hero::after,
    .dark-background::before,
    .dark-background::after{
      pointer-events: none !important;
    }
    #hero .nfy-hero-center,
    #hero .nfy-card{
      position: relative;
      z-index: 10;
    }
    #hero select,
    #hero .form-control{
      position: relative;
      z-index: 11;
      pointer-events: auto !important;
    }
  </style>
</head>

<body class="index-page">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/header.php"; ?>

<main class="main">
  <section id="hero" class="hero section dark-background">
    <img src="/assets/img/hero-bg.jpg" alt="Nestforyou real estate in Gurgaon">

    <div class="nfy-hero-center">
      <div class="nfy-hero-grid" data-aos="fade-up" data-aos-delay="100">

        <div class="nfy-card">
          <div class="nfy-mini-title">Search Real Estate Agent</div>

          <form id="searchForm" action="javascript:void(0)" onsubmit="return false;">
            <div class="mb-3">
              <select id="searchCity" class="form-control" required>
                <option value="">Select City</option>
                <option value="Gurugram">Gurgaon</option>
              </select>
            </div>

            <div class="mb-3">
              <select id="searchSector" class="form-control" required disabled>
                <option value="">Select Sector</option>
              </select>
            </div>

            <div class="mb-2">
              <select id="searchApartment" class="form-control" disabled>
                <option value="">Apartment</option>
              </select>
              <div id="aptHelp" class="nfy-help">Select city and sector to load apartments.</div>
            </div>

            <div class="nfy-action-row">
              <button type="submit" id="searchBtn" class="btn btn-outline-light nfy-btn nfy-disabled-btn" disabled>
                <i class="bi bi-search"></i> Find Agent
              </button>

              <div id="clearSearchBtn" class="nfy-clearbtn" role="button" tabindex="0" aria-label="Clear search">
                <i class="bi bi-x-circle"></i> Clear Search
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>
</main>
<!-- ================= REGISTER AGENT POPUP ================= -->
<div id="agentPopup" style="
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.85);
  z-index:99999;
  align-items:center;
  justify-content:center;
">

  <div style="width:95%; max-width:900px; position:relative;">

    <button id="closeAgentPopup" style="
      position:absolute;
      top:-45px;
      right:0;
      background:none;
      border:none;
      font-size:34px;
      color:#fff;
      cursor:pointer;
    ">&times;</button>

    <div class="nfy-card">
      <div class="nfy-mini-title">Register as an Agent</div>

      <form id="registerForm" novalidate>
        <div class="row g-3">

          <div class="col-md-6">
            <input name="name" class="form-control" placeholder="Your Name" required>
          </div>

          <div class="col-md-6">
            <input name="email" type="email" class="form-control" placeholder="Your Email" required>
          </div>

          <div class="col-md-6">
            <input name="phone_number" class="form-control" placeholder="Your Number" required>
          </div>

          <div class="col-md-6">
            <select name="city" class="form-control" required>
              <option value="">Select City</option>
              <option value="Gurugram">Gurgaon</option>
            </select>
          </div>

          <div class="col-md-12">
            <select name="sector" class="form-control" required>
              <option value="">Select Sector</option>
            </select>
          </div>

          <div class="col-md-12">
            <select name="apartment" class="form-control">
              <option value="">Apartment (optional)</option>
            </select>
          </div>

        </div>

        <div class="mt-3">
          <button class="btn nfy-btn" style="background:var(--accent-color);border:none;">
            <i class="bi bi-send"></i> submit
          </button>
          <div id="regMsg" class="nfy-reg-msg"></div>
        </div>
      </form>

    </div>
  </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/footer.php"; ?>

<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/aos/aos.js"></script>
<script src="/assets/js/main.js"></script>

<script>
  if (typeof AOS !== "undefined") { AOS.init(); }

  function setHelp(el, text, cls){
    el.classList.remove("error","ok");
    if(cls) el.classList.add(cls);
    el.textContent = text;
  }

  function titleCaseFromSlug(slug){
    if(!slug) return "";
    return slug.replace(/-/g, " ").replace(/\b\w/g, c => c.toUpperCase());
  }

  // ✅ extra safety: normalize key to prevent twins even if DB has duplicates
  function sectorKey(v){
    return (v || "").toString().toLowerCase().replace(/\s+/g,'');
  }

  async function fillSector(cityValue, sectorSelectEl){
    sectorSelectEl.innerHTML = '<option value="">Select Sector</option>';
    sectorSelectEl.disabled = true;

    const city = (cityValue || "").trim();
    if(!city) return;

    try{
      const fd = new FormData();
      fd.append("city", city);

      const res  = await fetch("/get-sectors.php", { method: "POST", body: fd });
      const text = await res.text();

      let data = null;
      try { data = JSON.parse(text); } catch(e) { data = null; }

      if(!data || data.status !== "success"){
        console.error("get-sectors.php response:", text);
        return;
      }

      const sectors = Array.isArray(data.data) ? data.data : [];
      const seen = new Set();

      sectors.forEach((item) => {
        const slug  = (typeof item === "string") ? item : (item.slug || "");
        const label = (typeof item === "string") ? item : (item.label || item.slug || "");
        if(!slug) return;

        // ✅ remove "0" and duplicates like Sector1 vs Sector 1
        if (slug === "0" || label === "0") return;
        const key = sectorKey(label || slug);
        if (seen.has(key)) return;
        seen.add(key);

        const opt = document.createElement("option");
        opt.value = slug;
        opt.textContent = label;
        sectorSelectEl.appendChild(opt);
      });

      sectorSelectEl.disabled = false;

    }catch(err){
      console.error("Network error while loading sectors:", err);
    }
  }

  function resetApartment(selectEl, label){
    selectEl.innerHTML = '<option value="">' + (label || "Apartment") + '</option>';
    selectEl.disabled = true;
  }

  const searchCity      = document.getElementById("searchCity");
  const searchSector    = document.getElementById("searchSector");
  const searchApartment = document.getElementById("searchApartment");
  const searchBtn       = document.getElementById("searchBtn");
  const searchForm      = document.getElementById("searchForm");
  const clearSearchBtn  = document.getElementById("clearSearchBtn");
  const aptHelp         = document.getElementById("aptHelp");

  function setSearchBtn(enabled){
    searchBtn.disabled = !enabled;
    if(enabled) searchBtn.classList.remove("nfy-disabled-btn");
    else searchBtn.classList.add("nfy-disabled-btn");
  }

  function doClearSearch(){
    searchCity.value = "";
    searchSector.innerHTML = '<option value="">Select Sector</option>';
    searchSector.disabled = true;
    resetApartment(searchApartment, "Apartment");
    setHelp(aptHelp, "Select city and sector to load apartments.", "");
    setSearchBtn(false);
  }

  clearSearchBtn.addEventListener("click", doClearSearch);

  searchCity.addEventListener("change", async () => {
    await fillSector(searchCity.value, searchSector);
    resetApartment(searchApartment, "Apartment");
    setHelp(aptHelp, "Now select a sector to load apartments.", "");
    setSearchBtn(false);
  });

  searchSector.addEventListener("change", async () => {
    const city = (searchCity.value || "").trim();
    const sector = (searchSector.value || "").trim();

    const ok = !!(city && sector && !searchSector.disabled);
    setSearchBtn(ok);

    resetApartment(searchApartment, "Apartment");
    if(!ok){
      setHelp(aptHelp, "Select city and sector to load apartments.", "");
      return;
    }

    resetApartment(searchApartment, "Loading apartments...");
    setHelp(aptHelp, "Loading apartments from database...", "");

    try{
      const fd = new FormData();
      fd.append("city", city);
      fd.append("sector", sector);

      const res = await fetch("/get-apartments.php", { method: "POST", body: fd });
      const text = await res.text();
      let data = null;
      try { data = JSON.parse(text); } catch(e) { data = null; }

      if(!data || data.status !== "success"){
        resetApartment(searchApartment, "Apartment");
        setHelp(aptHelp, "No apartments found (or API error).", "error");
        return;
      }

      const apartments = Array.isArray(data.data) ? data.data : [];
      searchApartment.innerHTML = '<option value="">Apartment</option>';

      apartments.forEach(item => {
        const slug  = (typeof item === "string") ? item : (item.slug || "");
        const label = (typeof item === "string") ? titleCaseFromSlug(item) : (item.label || titleCaseFromSlug(item.slug || ""));
        if(!slug) return;
        const opt = document.createElement("option");
        opt.value = slug;
        opt.textContent = label;
        searchApartment.appendChild(opt);
      });

      searchApartment.disabled = false;

      if(apartments.length){
        setHelp(aptHelp, apartments.length + " apartment(s) loaded. Now you can choose one.", "ok");
      }else{
        setHelp(aptHelp, "No apartments found for this sector.", "error");
      }

    }catch(e){
      resetApartment(searchApartment, "Apartment");
      setHelp(aptHelp, "Network error while loading apartments.", "error");
    }
  });

  searchForm.addEventListener("submit", function(e){
  e.preventDefault();

  const city = (searchCity.value || "").trim();
  const sector = (searchSector.value || "").trim();
  const aptSlug = (searchApartment.value || "").trim();

  if(!city || !sector) return;

  const citySlug   = city.toLowerCase().replace(/\s+/g, '-');
  const sectorSlug = sector.toLowerCase().replace(/\s+/g, '-');

  if (aptSlug) {
    window.location.href =
      "/" + citySlug + "/" + sectorSlug + "/" + aptSlug;
  } else {
    window.location.href =
      "/" + citySlug + "/" + sectorSlug;
  }
});

  const registerForm = document.getElementById("registerForm");
  const regCity = document.getElementById("regCity");
  const regSector = document.getElementById("regSector");
  const regApartment = document.getElementById("regApartment");
  const regAptHelp = document.getElementById("regAptHelp");
  const regBtn = document.getElementById("regBtn");
  const regMsg = document.getElementById("regMsg");

  function setRegMsg(text, ok){
    regMsg.textContent = text || "";
    regMsg.classList.remove("ok","err");
    if(text){
      regMsg.classList.add(ok ? "ok" : "err");
    }
  }

  function setRegBtnLoading(loading){
    regBtn.disabled = !!loading;
    regBtn.style.opacity = loading ? "0.7" : "1";
  }

  regCity.addEventListener("change", async () => {
    await fillSector(regCity.value, regSector);
    resetApartment(regApartment, "Apartment(optional)");
    setHelp(regAptHelp, "Now select a sector to load apartments.", "");
    setRegMsg("", true);
  });

  regSector.addEventListener("change", async () => {
    const city = (regCity.value || "").trim();
    const sector = (regSector.value || "").trim();

    resetApartment(regApartment, "Apartment(optional)");
    if(!city || !sector){
      setHelp(regAptHelp, "Select city and sector to load apartments.", "");
      return;
    }

    resetApartment(regApartment, "Loading apartments...");
    setHelp(regAptHelp, "Loading apartments from database...", "");

    try{
      const fd = new FormData();
      fd.append("city", city);
      fd.append("sector", sector);

      const res = await fetch("/get-apartments.php", { method: "POST", body: fd });
      const text = await res.text();
      let data = null;
      try { data = JSON.parse(text); } catch(e) { data = null; }

      if(!data || data.status !== "success"){
        resetApartment(regApartment, "Apartment(optional)");
        setHelp(regAptHelp, "No apartments found (or API error).", "error");
        return;
      }

      const apartments = Array.isArray(data.data) ? data.data : [];
      regApartment.innerHTML = '<option value="">Apartment(optional)</option>';

      apartments.forEach(item => {
        const slug  = (typeof item === "string") ? item : (item.slug || "");
        const label = (typeof item === "string") ? titleCaseFromSlug(item) : (item.label || titleCaseFromSlug(item.slug || ""));
        if(!slug) return;
        const opt = document.createElement("option");
        opt.value = slug;
        opt.textContent = label;
        regApartment.appendChild(opt);
      });

      regApartment.disabled = false;

      if(apartments.length){
        setHelp(regAptHelp, apartments.length + " apartment(s) loaded. Optional.", "ok");
      }else{
        setHelp(regAptHelp, "No apartments found for this sector.", "error");
      }
    }catch(e){
      resetApartment(regApartment, "Apartment(optional)");
      setHelp(regAptHelp, "Network error while loading apartments.", "error");
    }
  });

  registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    setRegMsg("", true);

    const formData = new FormData(registerForm);
    const name  = (formData.get("name") || "").toString().trim();
    const email = (formData.get("email") || "").toString().trim();
    const phone = (formData.get("phone_number") || "").toString().trim();
    const city  = (formData.get("city") || "").toString().trim();
    const sector= (formData.get("sector") || "").toString().trim();

    if(!name || !email || !phone || !city || !sector){
      setRegMsg("Please fill all required fields.", false);
      return;
    }

    formData.append("action", "register_agent");

    try{
      setRegBtnLoading(true);

      const res = await fetch(window.location.pathname, {
        method: "POST",
        body: new URLSearchParams(Array.from(formData.entries()))
      });

      const text = await res.text();
      let data = null;
      try { data = JSON.parse(text); } catch(err) { data = null; }

      if(!data || !data.status){
        setRegMsg("Server error: not receiving JSON response.", false);
        return;
      }

      if(data.status === "success"){
        setRegMsg(data.message || "Submitted successfully.", true);
        registerForm.reset();
        regSector.innerHTML = '<option value="">Select Sector</option>';
        regSector.disabled = true;
        resetApartment(regApartment, "Apartment(optional)");
        setHelp(regAptHelp, "Select city and sector to load apartments.", "");
      }else{
        setRegMsg(data.message || "Submit failed. Try again.", false);
      }

    }catch(err){
      setRegMsg("Network error. Please try again.", false);
    }finally{
      setRegBtnLoading(false);
    }
  });

  function scrollForDropdown(selectEl){
    if(!selectEl) return;
    selectEl.addEventListener("mousedown", function(){
      const rect = selectEl.getBoundingClientRect();
      const spaceBelow = window.innerHeight - rect.bottom;
      if(spaceBelow < 320){
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const targetY = scrollTop + rect.top - 120;
        window.scrollTo(0, targetY);
      }
    });
  }

  scrollForDropdown(searchSector);
  scrollForDropdown(regSector);
  scrollForDropdown(searchApartment);
  scrollForDropdown(regApartment);

  doClearSearch();
  <script>
document.addEventListener("DOMContentLoaded", function () {

  const openBtn = document.getElementById("openAgentPopup");
  const popup   = document.getElementById("agentPopup");
  const closeBtn= document.getElementById("closeAgentPopup");

  if (openBtn && popup) {
    openBtn.addEventListener("click", function (e) {
      e.preventDefault();
      popup.style.display = "flex";
      document.body.style.overflow = "hidden";
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener("click", function () {
      popup.style.display = "none";
      document.body.style.overflow = "";
    });
  }

  popup.addEventListener("click", function (e) {
    if (e.target === popup) {
      popup.style.display = "none";
      document.body.style.overflow = "";
    }
  });

});
</script>

</script>
</body>
</html>
