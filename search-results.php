<?php
// search-results.php

$base_url = "https://nestforyou.in";
$path = strtok($_SERVER["REQUEST_URI"], '?');
$path = preg_replace('#/index\.php$#i', '/', $path);
$path = '/' . ltrim($path, '/');
$canonical = rtrim($base_url . $path, '/');
if ($canonical === $base_url) $canonical .= '/';

$city      = isset($_GET["city"]) ? trim($_GET["city"]) : "";
$sector    = isset($_GET["sector"]) ? trim($_GET["sector"]) : "";
$apartment = isset($_GET["apartment"]) ? trim($_GET["apartment"]) : ""; // optional (slug or label)

function is_valid_value($v){
  return $v !== "" && preg_match('/^[a-zA-Z0-9\s\-]+$/', $v);
}
function is_valid_apartment($v){
  // allow slug like "suncity-avenue" or label like "Suncity Avenue"
  return $v === "" || preg_match('/^[a-zA-Z0-9\s\-]+$/', $v);
}

$hasParams = is_valid_value($city) && is_valid_value($sector) && is_valid_apartment($apartment);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>Agent Results | Nestforyou</title>
<link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

<meta name="description" content="Find verified real estate agents by city and sector on Nestforyou.">
<meta name="robots" content="noindex,follow">

<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/assets/css/main.css" rel="stylesheet">

<style>
/* HERO */
#hero{
  position: relative;
  min-height: calc(100vh - 170px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 120px 12px 80px;
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

/* INTRO TEXT */
.nfy-intro-outside{
  max-width: 1180px;
  margin: 0 auto 22px auto;
  text-align: center;
  color: #ffffff;
  font-size: 20px;
  line-height: 1.7;
  font-weight: 600;
  opacity: 0.96;
}

/* RESULT CARD */
.nfy-shell{
  max-width: 1180px;
  margin: 0 auto;
  border: 1px solid rgba(255,255,255,0.10);
  border-radius: 14px;
  padding: 22px;
  box-shadow: 0 18px 50px rgba(0,0,0,0.25);
  color: #fff;
  background: rgba(0,0,0,0.20);
  backdrop-filter: blur(2px);
}

/* TITLE */
.nfy-title{
  font-family: var(--heading-font);
  font-weight: 700;
  letter-spacing: 1.2px;
  font-size: 13px;
  color: rgba(255,255,255,0.78);
  text-transform: uppercase;
  margin-bottom: 8px;
  position: relative;
  padding-bottom: 10px;
}
.nfy-title:after{
  content:"";
  position:absolute;
  left:0;
  bottom:0;
  width: 120px;
  height: 2px;
  background: var(--accent-color);
}

/* PILLS */
.nfy-sub{
  margin-top: 10px;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}
.nfy-pill{
  display:inline-flex;
  align-items:center;
  gap:8px;
  border: 1px solid rgba(255,255,255,0.20);
  border-radius: 999px;
  padding: 6px 12px;
  background: rgba(0,0,0,0.15);
  color: rgba(255,255,255,0.9);
  font-size: 14px;
}
.nfy-pill i{ color: var(--accent-color); }

/* RESULTS */
.nfy-results-wrap{ margin-top: 16px; }
.nfy-results-grid{
  display:grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 14px;
}
.nfy-result-card{
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(255,255,255,0.10);
  border-radius: 14px;
  padding: 16px;
}
.nfy-result-name{
  font-weight: 900;
  font-size: 18px;
  margin-bottom: 10px;
}

.nfy-msg{
  margin-top: 14px;
  text-align:center;
  font-weight: 800;
}
.nfy-msg-ok{ color: var(--accent-color); }
.nfy-msg-err{ color: #ff6b6b; }

/* Search Again bar/button */
.nfy-search-again{
  margin-top: 12px;
  display:none;
}
.nfy-search-again a{
  width: 100%;
  border-radius: 12px;
  font-weight: 800;
  padding: 12px 14px;
}

/* ============================= */
/* SMALLER – OTHER AREAS SECTION */
/* ============================= */
.nfy-related-outside{
  max-width: 1180px;
  margin: 18px auto 0;
}

.nfy-related-title{
  font-family: var(--heading-font);
  font-weight: 900;
  font-size: 20px;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  text-align: center;
  color: #fff;
}

.nfy-related-underline{
  width: 42px;
  height: 2px;
  background: var(--accent-color);
  margin: 8px auto;
}

.nfy-related-subtitle{
  text-align: center;
  font-size: 13px;
  color: rgba(255,255,255,0.7);
  margin-bottom: 12px;
}

.nfy-related-grid{
  display: grid;
  grid-template-columns: repeat(2, minmax(0,1fr));
  gap: 12px;
}

.nfy-related-card{
  display: block;
  text-decoration: none;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 10px;
  padding: 14px 12px;
  text-align: center;
  color: #fff;
}

.nfy-related-card h3{
  margin: 0;
  font-size: 16px;
  font-weight: 800;
  line-height: 1.35;
}

@media(max-width:768px){
  .nfy-results-grid{ grid-template-columns:1fr; }
  .nfy-related-grid{ grid-template-columns:1fr; }
  .nfy-intro-outside{ font-size:17px; }
}
</style>
</head>

<body class="index-page">

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/header.php"; ?>

<main class="main">
<section id="hero" class="hero section dark-background">
<img src="/assets/img/hero-bg.jpg" alt="Nestforyou agent results">

<div class="nfy-hero-center">

  <div class="nfy-intro-outside">
    Explore property options and connect with verified real estate agents in your locality.<br>
    Get expert help for renting, buying, or selling—right where it matters.
  </div>

  <div class="nfy-shell">

    <div class="nfy-title">Agent Results</div>

    <div class="nfy-sub">
      <span class="nfy-pill"><i class="bi bi-geo-alt"></i> City:
        <strong><?php echo htmlspecialchars($city ?: "-", ENT_QUOTES); ?></strong>
      </span>
      <span class="nfy-pill"><i class="bi bi-buildings"></i> Sector:
        <strong><?php echo htmlspecialchars($sector ?: "-", ENT_QUOTES); ?></strong>
      </span>
      <?php if($apartment): ?>
      <span class="nfy-pill"><i class="bi bi-building"></i> Apartment:
        <strong><?php echo htmlspecialchars($apartment, ENT_QUOTES); ?></strong>
      </span>
      <?php endif; ?>
    </div>

    <div class="nfy-msg nfy-msg-err" id="errMsg"></div>
    <div class="nfy-msg nfy-msg-ok" id="okMsg"></div>

    <div class="nfy-search-again" id="searchAgainWrap">
      <a class="btn btn-outline-light" href="/"><i class="bi bi-arrow-left"></i> Search Again</a>
    </div>

    <div class="nfy-results-wrap">
      <div class="nfy-results-grid" id="resultsGrid"></div>
    </div>

  </div>

  <div class="nfy-related-outside">
    <div class="nfy-related-title">OTHER AREAS WE SERVE</div>
    <div class="nfy-related-underline"></div>
    <div class="nfy-related-subtitle">Explore real estate services in nearby areas</div>

    <div class="nfy-related-grid">
      <a class="nfy-related-card" id="rentCard" href="#"><h3 id="rentTitle">Rent Property</h3></a>
      <a class="nfy-related-card" id="buyCard" href="#"><h3 id="buyTitle">Buy Property</h3></a>
      <a class="nfy-related-card" id="agentSector1Card" href="#"><h3 id="agentSector1Title">Real Estate Agents</h3></a>
      <a class="nfy-related-card" id="agentSector3Card" href="#"><h3 id="agentSector3Title">Real Estate Agents</h3></a>
    </div>
  </div>

</div>
</section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common file/footer.php"; ?>

<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
const city = <?php echo json_encode($city); ?>;
const sector = <?php echo json_encode($sector); ?>;
const apartment = <?php echo json_encode($apartment); ?>;
const hasParams = <?php echo $hasParams ? "true" : "false"; ?>;

const grid = document.getElementById("resultsGrid");
const okMsg = document.getElementById("okMsg");
const errMsg = document.getElementById("errMsg");
const searchAgainWrap = document.getElementById("searchAgainWrap");

/* Other Areas */
function cityToSlug(c){
  const v = (c || "").trim().toLowerCase();
  if(v === "gurugram" || v === "gurgaon") return "gurgaon";
  return v.replace(/\s+/g, "-");
}
function cityToLabel(c){
  const v = (c || "").trim();
  if(v.toLowerCase() === "gurugram") return "Gurgaon";
  return v;
}
(function setOtherAreaCards(){
  const cityLabel = cityToLabel(city);
  const citySlug  = cityToSlug(city);

  document.getElementById("rentTitle").textContent =
    "Rent Property in " + cityLabel;

  document.getElementById("buyTitle").textContent =
    "Buy Property in " + cityLabel;

  document.getElementById("agentSector1Title").textContent =
    "Real Estate Agents in Sector 1, " + cityLabel;

  document.getElementById("agentSector3Title").textContent =
    "Real Estate Agents in Sector 3, " + cityLabel;

  // ✅ FIXED URLs (MATCH .htaccess)
 document.getElementById("rentCard").href =
  "/real-estate/rent/" + citySlug + "/";

document.getElementById("buyCard").href =
  "/buy/" + citySlug + "/";
 document.getElementById("agentSector1Card").href =
    "/real-estate-agent/" + citySlug + "/sector-1/"; // Updated to match real-estate-agent/{city}/sector-{sector}

  document.getElementById("agentSector3Card").href =
    "/real-estate-agent/" + citySlug + "/sector-3/"; // Updated to match real-estate-agent/{city}/sector-{sector}
})();


/* Normalize + variants */
function normalizeSectorForAPI(v){
  const s = String(v || "").trim();

  // Sector 3 / sector 3 / sector3 → Sector 3
  const m = s.match(/^sector\s*(\d+)$/i);
  if(m){
    return "Sector " + m[1];
  }

  // fallback: Title Case
  return s.replace(/\b\w/g, c => c.toUpperCase());
}

function titleCaseCity(v){
  const s = String(v || "").trim();
  if(!s) return s;
  return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase();
}
function cityVariantsForAPI(c){
  const s = String(c || "").trim();
  const lower = s.toLowerCase();
  if(lower === "gurgaon" || lower === "gurugram"){
    return ["Gurgaon","Gurugram","gurgaon","gurugram"];
  }
  const tc = titleCaseCity(s);
  const arr = [s, lower, tc].filter(Boolean);
  return [...new Set(arr)];
}
async function postSearch(cityValue, sectorValue, apartmentValue){
  const params = {
    city: cityValue,
    sector: sectorValue
  };

  // ✅ send apartment ONLY if selected
  if(apartmentValue){
    params.apartment = apartmentValue;
  }

  const res = await fetch("/search-city.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
    body: new URLSearchParams(params)
  });

  const text = await res.text();
  try{ 
    return JSON.parse(text); 
  }
  catch(e){ 
    throw new Error("Invalid JSON: " + text.slice(0,200)); 
  }
}

function prettyAptLabel(v){
  const s = String(v || "").trim();
  if(!s) return s;
  // if slug => Title Case
  if(/^[a-z0-9\-]+$/i.test(s) && s.includes("-")){
    return s.replace(/-/g," ").replace(/\b\w/g,c=>c.toUpperCase());
  }
  return s;
}

/* Load agents */
async function loadAgents(){
  errMsg.textContent = "";
  okMsg.textContent = "";
  grid.innerHTML = "";
  searchAgainWrap.style.display = "none";

  if(!hasParams){
    errMsg.textContent = "Invalid city or sector.";
    return;
  }

  const sectorNorm = normalizeSectorForAPI(sector);
  const cityTries = cityVariantsForAPI(city);

  let found = false;

  for(const c of cityTries){
    try{
      const d = await postSearch(c, sectorNorm, apartment);

      if(d && d.status === "success" && Array.isArray(d.data) && d.data.length){
        found = true;
        d.data.forEach(r=>{
          grid.innerHTML += `
            <div class="nfy-result-card">
              <div class="nfy-result-name">${r.name || ""}</div>
              <div>📍 ${r.city || ""}</div>
              <div>📞 <a href="tel:${r.phone_number || ""}" style="color: var(--accent-color); font-weight:800; text-decoration:none;">${r.phone_number || ""}</a></div>
              <div>✉ <a href="mailto:${r.email || ""}" style="color: var(--accent-color); font-weight:800; text-decoration:none;">${r.email || ""}</a></div>
            </div>`;
        });
        return;
      }
    }catch(e){
      // try next variant
    }
  }

  // ✅ Final message
  if(!found){
    if(apartment){
      errMsg.textContent = "Sorry, we have no agent in " + prettyAptLabel(apartment) + ".";
      searchAgainWrap.style.display = "block";
    } else {
      okMsg.textContent = "No agents found for selected city/sector.";
    }
  }
}

loadAgents();
</script>

</body>
</html>
