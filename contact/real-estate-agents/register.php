<?php
// contact/index.php  (or your contact page path)

// ==============================
// Base URL + Canonical (clean)
// ==============================
$base_url = "https://nestforyou.in";

// Remove query string from canonical
$path = strtok($_SERVER["REQUEST_URI"], '?');

// Remove trailing index.php from canonical
$path = preg_replace('#/index\.php$#i', '/', $path);

// Normalize slashes
$path = '/' . ltrim($path, '/');

// Build canonical
$canonical = rtrim($base_url . $path, '/');
if ($canonical === $base_url) $canonical .= '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Nest For You – Contact</title>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

  <meta name="description" content="Contact Nest For You to connect with verified real estate experts for rent, buy, or sell enquiries.">
  <meta name="keywords" content="Nestforyou contact, real estate enquiry, rent buy sell, Gurgaon property consultants">

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
    .nfy-contact-wrap{
      padding-top: 95px;
      padding-bottom: 60px;
    }

    .nfy-contact-card{
      max-width: 820px;
      margin: 0 auto;
      background: #0b0b0b;
      border: 1px solid rgba(255,255,255,0.10);
      border-radius: 14px;
      padding: 34px 34px;
      box-shadow: 0 18px 50px rgba(0,0,0,0.25);
      color: #fff;
      overflow: visible;
    }

    .nfy-contact-title{
      font-family: var(--heading-font);
      font-weight: 700;
      letter-spacing: 1.5px;
      font-size: 14px;
      color: rgba(255,255,255,0.75);
      margin: 0 0 18px;
      text-transform: uppercase;
      position: relative;
      padding-bottom: 14px;
    }
    .nfy-contact-title:after{
      content:"";
      position:absolute;
      left:0;
      bottom:0;
      width:120px;
      height:2px;
      background: var(--accent-color);
    }

    /* ✅ PERFECT ALIGNMENT: each field is a grid item + same height */
    .nfy-grid{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
      align-items: stretch;
    }
    .nfy-field{ min-width: 0; }
    .nfy-field .form-control{ width: 100%; }

    /* same height for inputs + selects (city/sector) */
    .nfy-contact-card .php-email-form .form-control{
      height: 50px !important;         /* ✅ matches other columns */
      line-height: 50px !important;    /* ✅ keeps text vertically centered */
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }

    /* textarea (if you add later) should not be forced */
    .nfy-contact-card .php-email-form textarea.form-control{
      height: auto !important;
      line-height: 1.5 !important;
      padding: 12px 14px !important;
    }

    /* ✅ ONLY CHANGE: move Select City a little lower */
    .nfy-city-down{
      margin-top: 8px; /* adjust to 6px / 10px if you want */
    }

    .nfy-captcha{
      margin-top: 18px;
      text-align: center;
    }
    .nfy-captcha strong{
      display:block;
      margin-bottom: 10px;
      color: var(--accent-color);
      font-size: 18px;
    }
    .nfy-captcha input{
      max-width: 260px;
      margin: 0 auto;
    }

    .nfy-disabled-btn{
      opacity: 0.6;
      cursor: not-allowed;
      pointer-events: none;
    }

    .nfy-success{
      display:none;
      margin-top: 14px;
      text-align:center;
      font-weight: 600;
      color: var(--accent-color);
    }

    .nfy-error{
      display:none;
      margin-top: 12px;
      text-align:center;
      font-weight: 600;
      color: #ff6b6b;
    }

    @media (max-width: 768px){
      .nfy-contact-wrap{
        padding-top: 130px;
        padding-bottom: 60px;
      }
      .nfy-contact-card{
        padding: 26px 18px;
        margin-top: 10px;
      }
      .nfy-grid{
        grid-template-columns: 1fr;
      }
    }

    /* ✅ White inputs ONLY in this card */
    .nfy-contact-card .php-email-form input,
    .nfy-contact-card .php-email-form textarea,
    .nfy-contact-card .php-email-form select{
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
    .nfy-contact-card .php-email-form input::placeholder,
    .nfy-contact-card .php-email-form textarea::placeholder{
      color: #777777;
    }

    #sectorSelect:disabled{
      opacity: 0.7;
      cursor: not-allowed;
    }
  </style>
</head>

<body class="index-page">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/header.php"; ?>

<main class="main">
  <section class="contact section nfy-contact-wrap">
    <div class="container" data-aos="fade-up" data-aos-delay="50">
      <div class="nfy-contact-card">

        <div class="nfy-contact-title">Nest For You</div>

        <form id="contactForm" class="php-email-form" action="javascript:void(0)" onsubmit="return false;" novalidate>
          <div class="nfy-grid">

            <div class="nfy-field">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>

            <div class="nfy-field">
              <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>

            <div class="nfy-field">
              <input type="text" name="phone_number" class="form-control" placeholder="Your Number" required>
            </div>

            <!-- ✅ City unchanged, only moved down via wrapper class -->
            <div class="nfy-field nfy-city-down">
              <select id="citySelect" name="city" class="form-control" required>
                <option value="">Select City</option>
                <option>Gurugram</option>
              </select>
            </div>

            <!-- ✅ Sector same size as others -->
            <div class="nfy-field">
              <select id="sectorSelect" name="sector" class="form-control" required disabled>
                <option value="">Select sector</option>
              </select>
            </div>
            <div class="nfy-field">
              <select id="apartment" name="apartment" class="form-control" required disabled>
                <option value="">Apartment</option>
              </select>
            </div>

          </div>

          <div class="nfy-captcha">
            <strong>12 + 8</strong>
            <input type="text" id="captcha" class="form-control" placeholder="Enter the value" required>
          </div>

          <div class="col-12 text-center mt-3">
            <button type="submit" id="submitBtn" class="nfy-disabled-btn" disabled>SEND MESSAGE</button>

            <div class="nfy-success" id="successMsg">
              <i class="bi bi-check2-square"></i> Submitted Successfully
            </div>

            <div class="nfy-error" id="errorMsg"></div>
          </div>
        </form>

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

  // City -> Sector (sector1..sector4)
  const citySelect = document.getElementById("citySelect");
  const sectorSelect = document.getElementById("sectorSelect");
  const sectorOptions = ["sector1","sector2","sector3","sector4"];

  function fillSectors() {
    sectorSelect.innerHTML = '<option value="">Select sector</option>';

    if (!citySelect.value || citySelect.value.trim() === "") {
      sectorSelect.disabled = true;
      return;
    }

    sectorOptions.forEach((s) => {
      const opt = document.createElement("option");
      opt.value = s;
      opt.textContent = s;
      sectorSelect.appendChild(opt);
    });

    sectorSelect.disabled = false;
  }
  citySelect.addEventListener("change", fillSectors);

  // Form + captcha + AJAX submit
  const form = document.getElementById("contactForm");
  const submitBtn = document.getElementById("submitBtn");
  const captchaInput = document.getElementById("captcha");
  const successMsg = document.getElementById("successMsg");
  const errorMsg = document.getElementById("errorMsg");

  function setBtnEnabled(enabled){
    submitBtn.disabled = !enabled;
    if(enabled){
      submitBtn.classList.remove("nfy-disabled-btn");
    }else{
      submitBtn.classList.add("nfy-disabled-btn");
    }
  }

  captchaInput.addEventListener("input", function () {
    const ok = (this.value.trim() === "20");
    setBtnEnabled(ok);
    successMsg.style.display = "none";
    errorMsg.style.display = "none";
  });

  form.addEventListener("submit", function(e){
    e.preventDefault();

    successMsg.style.display = "none";
    errorMsg.style.display = "none";

    if (captchaInput.value.trim() !== "20") {
      errorMsg.textContent = "Please solve the captcha correctly.";
      errorMsg.style.display = "block";
      return;
    }

    if (!citySelect.value || citySelect.value.trim() === "") {
      errorMsg.textContent = "Please select a city.";
      errorMsg.style.display = "block";
      return;
    }

    if (sectorSelect.disabled || !sectorSelect.value) {
      errorMsg.textContent = "Please select a sector.";
      errorMsg.style.display = "block";
      return;
    }

    setBtnEnabled(false);
    submitBtn.textContent = "SENDING...";

    const formData = new FormData(form);

    fetch("/database/store_data.php", {
      method: "POST",
      body: formData
    })
    .then(async (res) => {
      const text = await res.text();
      try { return JSON.parse(text); }
      catch { return { status: "error", message: "Server response not JSON" }; }
    })
    .then(data => {
      submitBtn.textContent = "SEND MESSAGE";

      if (data.status === "success") {
        successMsg.style.display = "block";
        form.reset();
        sectorSelect.innerHTML = '<option value="">Select sector</option>';
        sectorSelect.disabled = true;
        setBtnEnabled(false);
      } else {
        errorMsg.textContent = (data.message || "Something went wrong. Please try again.");
        errorMsg.style.display = "block";
      }
    })
    .catch(() => {
      submitBtn.textContent = "SEND MESSAGE";
      errorMsg.textContent = "Network error. Please try again.";
      errorMsg.style.display = "block";
    });
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
