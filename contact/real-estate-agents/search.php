<?php
// search/clients/index.php  (City + Sector dropdown, results show as cards BELOW form)

// ==============================
// Base URL + Canonical (clean)
// ==============================
$base_url = "https://nestforyou.in";
$path = strtok($_SERVER["REQUEST_URI"], '?');
$path = preg_replace('#/index\.php$#i', '/', $path);
$path = '/' . ltrim($path, '/');
$canonical = rtrim($base_url . $path, '/');
if ($canonical === $base_url) $canonical .= '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Search Clients by City & Sector | Nest For You</title>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

  <meta name="description" content="Search clients by city and sector on Nest For You. View results in a clean card layout.">
  <meta name="keywords" content="Nestforyou client search, city sector search, real estate leads search">

  <!-- Favicons -->
  <link href="https://nestforyou.in/assets/img/favicon.png" rel="icon">
  <link href="https://nestforyou.in/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="/assets/css/main.css" rel="stylesheet">

  <style>
    .nfy-search-wrap{ padding-top: 95px; padding-bottom: 60px; }

    .nfy-search-card{
      max-width: 980px; margin: 0 auto;
      background: #0b0b0b; border: 1px solid rgba(255,255,255,0.10);
      border-radius: 14px; padding: 34px 34px;
      box-shadow: 0 18px 50px rgba(0,0,0,0.25);
      color: #fff; overflow: visible;
    }

    .nfy-search-title{
      font-family: var(--heading-font);
      font-weight: 700; letter-spacing: 1.5px;
      font-size: 14px; color: rgba(255,255,255,0.75);
      margin: 0 0 18px; text-transform: uppercase;
      position: relative; padding-bottom: 14px;
    }
    .nfy-search-title:after{
      content:""; position:absolute; left:0; bottom:0;
      width:120px; height:2px; background: var(--accent-color);
    }

    .nfy-grid{
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 18px; align-items: stretch;
    }
    .nfy-field{ min-width: 0; }
    .nfy-field .form-control{ width: 100%; }

    .nfy-search-card .php-email-form .form-control{
      height: 50px !important;
      line-height: 50px !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    .nfy-search-card .php-email-form select{
      background-color: #ffffff !important;
      color: #000000 !important;
      border-color: #cccccc !important;
      appearance: auto !important;
      -webkit-appearance: auto !important;
      -moz-appearance: auto !important;
      pointer-events: auto !important;
      position: relative;
      z-index: 2;
      box-sizing: border-box;
    }

    .nfy-actions{
      display:flex; gap: 12px;
      justify-content:center; margin-top: 18px; flex-wrap: wrap;
    }

    .nfy-disabled-btn{ opacity: 0.6; cursor: not-allowed; pointer-events: none; }

    .nfy-msg{
      display:none; margin-top: 14px;
      text-align:center; font-weight: 600;
    }
    .nfy-error{ color: #ff6b6b; }
    .nfy-info{ color: rgba(255,255,255,0.85); }

    .nfy-results-wrap{ max-width: 980px; margin: 18px auto 0; }
    .nfy-results-grid{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 14px;
    }
    .nfy-result-card{
      background:#0b0b0b;
      border: 1px solid rgba(255,255,255,0.10);
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.22);
      padding: 16px 16px;
      color:#fff;
      min-height: 140px;
    }
    .nfy-result-name{ font-weight: 700; font-size: 16px; margin-bottom: 10px; }
    .nfy-result-line{
      display:flex; gap: 10px;
      align-items:flex-start;
      font-size: 14px;
      color: rgba(255,255,255,0.85);
      margin-bottom: 8px;
    }
    .nfy-result-line i{ color: var(--accent-color); margin-top: 2px; }
    .nfy-result-line a{
      color: rgba(255,255,255,0.90);
      text-decoration: none;
      border-bottom: 1px dashed rgba(255,255,255,0.35);
    }
    .nfy-result-line a:hover{ border-bottom-color: var(--accent-color); }

    .nfy-loader{
      display:none; margin-top: 14px;
      text-align:center; color: rgba(255,255,255,0.8);
    }

    @media (max-width: 992px){
      .nfy-results-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 768px){
      .nfy-search-wrap{ padding-top: 130px; padding-bottom: 60px; }
      .nfy-search-card{ padding: 26px 18px; margin-top: 10px; }
      .nfy-grid{ grid-template-columns: 1fr; }
      .nfy-results-grid{ grid-template-columns: 1fr; }
    }
  </style>
</head>

<body class="index-page">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/header.php"; ?>

<main class="main">
  <section class="contact section nfy-search-wrap">
    <div class="container" data-aos="fade-up" data-aos-delay="50">

      <div class="nfy-search-card">
        <div class="nfy-search-title">Nest For You</div>

        <form id="searchForm" class="php-email-form" action="javascript:void(0)" onsubmit="return false;" novalidate>
          <div class="nfy-grid">

            <div class="nfy-field">
              <select id="citySelect" name="city" class="form-control" required>
                <option value="">Select City</option>
                <option value="Delhi">Delhi</option>
                <option value="Gurugram">Gurugram</option>
                <option value="Noida">Noida</option>
                <option value="Faridabad">Faridabad</option>
              </select>
            </div>

            <div class="nfy-field">
              <select id="sectorSelect" name="sector" class="form-control" required disabled>
                <option value="">Select sector</option>
              </select>
            </div>

          </div>

          <div class="nfy-actions">
            <button type="submit" id="searchBtn" class="nfy-disabled-btn" disabled>SEARCH</button>
            <a href="#" id="resetBtn" class="btn btn-outline-light" role="button">RESET</a>
          </div>

          <div class="nfy-loader" id="loader">
            <i class="bi bi-arrow-repeat"></i> Loading results...
          </div>

          <div class="nfy-msg nfy-error" id="errorMsg"></div>
          <div class="nfy-msg nfy-info" id="infoMsg"></div>
        </form>
      </div>

      <div class="nfy-results-wrap">
        <div class="nfy-results-grid" id="resultsGrid"></div>
      </div>

    </div>
  </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/footer.php"; ?>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>
<div id="preloader"></div>

<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>
<script src="/assets/vendor/aos/aos.js"></script>
<script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="/assets/js/main.js"></script>

<script>
  if (typeof AOS !== "undefined") { AOS.init(); }

  const citySelect   = document.getElementById("citySelect");
  const sectorSelect = document.getElementById("sectorSelect");
  const searchBtn    = document.getElementById("searchBtn");
  const form         = document.getElementById("searchForm");
  const resetBtn     = document.getElementById("resetBtn");

  const loader   = document.getElementById("loader");
  const errorMsg = document.getElementById("errorMsg");
  const infoMsg  = document.getElementById("infoMsg");
  const resultsGrid = document.getElementById("resultsGrid");

  const sectorsByCity = {
    "Delhi": ["sector1","sector2","sector3","sector4"],
    "Gurugram": ["sector1","sector2","sector3","sector4"],
    "Noida": ["sector1","sector2","sector3","sector4"],
    "Faridabad": ["sector1","sector2","sector3","sector4"]
  };

  function setBtnEnabled(enabled){
    searchBtn.disabled = !enabled;
    if(enabled){
      searchBtn.classList.remove("nfy-disabled-btn");
    }else{
      searchBtn.classList.add("nfy-disabled-btn");
    }
  }

  function clearMessages(){
    errorMsg.style.display = "none"; errorMsg.textContent = "";
    infoMsg.style.display = "none"; infoMsg.textContent = "";
  }

  function setLoading(isLoading){
    loader.style.display = isLoading ? "block" : "none";
    if(isLoading){
      setBtnEnabled(false);
      searchBtn.textContent = "SEARCHING...";
    }else{
      searchBtn.textContent = "SEARCH";
    }
  }

  function fillSectors(){
    clearMessages();
    sectorSelect.innerHTML = '<option value="">Select sector</option>';
    sectorSelect.disabled = true;
    setBtnEnabled(false);

    const city = (citySelect.value || "").trim();
    if(!city) return;

    const list = sectorsByCity[city] || [];
    list.forEach((s) => {
      const opt = document.createElement("option");
      opt.value = s;
      opt.textContent = s;
      sectorSelect.appendChild(opt);
    });

    sectorSelect.disabled = false;
  }

  citySelect.addEventListener("change", fillSectors);

  sectorSelect.addEventListener("change", function(){
    const ok = !!(citySelect.value && sectorSelect.value);
    setBtnEnabled(ok);
  });

  function escapeHtml(str){
    return String(str ?? "")
      .replaceAll("&","&amp;")
      .replaceAll("<","&lt;")
      .replaceAll(">","&gt;")
      .replaceAll('"',"&quot;")
      .replaceAll("'","&#039;");
  }

  function renderResults(rows){
    resultsGrid.innerHTML = "";

    if(!rows || !rows.length){
      infoMsg.textContent = "No clients found for selected city/sector.";
      infoMsg.style.display = "block";
      return;
    }

    rows.forEach((r) => {
      const name  = escapeHtml(r.name || "");
      const city  = escapeHtml(r.city || "");
      const phone = escapeHtml(r.phone_number || "");
      const email = escapeHtml(r.email || "");

      const card = document.createElement("div");
      card.className = "nfy-result-card";
      card.innerHTML = `
        <div class="nfy-result-name">${name || "Unknown"}</div>

        <div class="nfy-result-line">
          <i class="bi bi-geo-alt"></i>
          <div>${city || "-"}</div>
        </div>

        <div class="nfy-result-line">
          <i class="bi bi-telephone"></i>
          <div>${phone ? `<a href="tel:${phone}">${phone}</a>` : "-"}</div>
        </div>

        <div class="nfy-result-line">
          <i class="bi bi-envelope"></i>
          <div>${email ? `<a href="mailto:${email}">${email}</a>` : "-"}</div>
        </div>
      `;
      resultsGrid.appendChild(card);
    });

    infoMsg.textContent = rows.length + " result(s) found.";
    infoMsg.style.display = "block";
  }

  // ✅ AJAX search (FIXED: show real server output when not JSON)
  form.addEventListener("submit", function(e){
    e.preventDefault();
    clearMessages();
    resultsGrid.innerHTML = "";

    const city = (citySelect.value || "").trim();
    const sector = (sectorSelect.value || "").trim();

    if(!city){
      errorMsg.textContent = "Please select a city.";
      errorMsg.style.display = "block";
      return;
    }
    if(!sector){
      errorMsg.textContent = "Please select a sector.";
      errorMsg.style.display = "block";
      return;
    }

    setLoading(true);

    const fd = new FormData();
    fd.append("city", city);
    fd.append("sector", sector);

    fetch("/search-city.php", {
      method: "POST",
      body: fd
    })
    .then(async (res) => {
      const text = await res.text();
      const trimmed = text.trim();

      // ✅ If server returned HTML/404/etc, show first 200 chars
      const looksLikeJson = trimmed.startsWith("{") || trimmed.startsWith("[");
      if (!looksLikeJson) {
        return {
          status: "error",
          message: "Server did not return JSON. First 200 chars: " + trimmed.slice(0, 200)
        };
      }

      try { return JSON.parse(trimmed); }
      catch {
        return {
          status: "error",
          message: "JSON parse failed. First 200 chars: " + trimmed.slice(0, 200)
        };
      }
    })
    .then((data) => {
      setLoading(false);

      if(data.status === "success"){
        renderResults(data.data || []);
        setBtnEnabled(true);
      }else if(data.status === "empty"){
        renderResults([]);
        setBtnEnabled(true);
      }else{
        errorMsg.textContent = data.message || "Something went wrong.";
        errorMsg.style.display = "block";
        setBtnEnabled(true);
      }
    })
    .catch(() => {
      setLoading(false);
      errorMsg.textContent = "Network error. Please try again.";
      errorMsg.style.display = "block";
      setBtnEnabled(true);
    });
  });

  resetBtn.addEventListener("click", function(e){
    e.preventDefault();
    form.reset();
    clearMessages();
    resultsGrid.innerHTML = "";
    sectorSelect.innerHTML = '<option value="">Select sector</option>';
    sectorSelect.disabled = true;
    setBtnEnabled(false);
  });
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-85WFRDYBJX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-85WFRDYBJX');
</script>

</body>
</html>
