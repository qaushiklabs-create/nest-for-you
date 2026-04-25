<?php
// register-agent/index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register as an Agent | Nestforyou</title>

<link href="/nestforyou/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/nestforyou/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/nestforyou/assets/css/main.css" rel="stylesheet">

<style>
/* ================= HERO ================= */
#register-hero{
  position:relative;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:120px 12px 80px;
}
#register-hero img{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  object-fit:cover;
  z-index:1;
}
#register-hero::after{
  content:"";
  position:absolute;
  inset:0;
  background:rgba(0,0,0,0.65);
  z-index:2;
}

/* ================= CARD ================= */
.register-card{
  position:relative;
  z-index:5;
  max-width:960px;
  width:100%;
  background:rgba(0,0,0,0.55);
  border:1px solid rgba(255,255,255,0.15);
  border-radius:18px;
  padding:36px;
  color:#fff;
  box-shadow:0 20px 60px rgba(0,0,0,0.4);
}

.register-title{
  font-size:14px;
  letter-spacing:1.4px;
  text-transform:uppercase;
  color:rgba(255,255,255,0.8);
  margin-bottom:22px;
  padding-bottom:10px;
  position:relative;
  font-weight:700;
}
.register-title::after{
  content:"";
  position:absolute;
  left:0;
  bottom:0;
  width:90px;
  height:2px;
  background:#f5b000;
}

/* ================= INPUTS ================= */
.register-card .form-control{
  height:54px;
  border-radius:12px;
  background:#fff !important;
  color:#000 !important;
  font-size:15px;
  padding:0 14px;
}

/* ================= HELP ================= */
.register-help{
  font-size:13px;
  color:rgba(255,255,255,0.75);
  margin-top:6px;
}

/* ================= BUTTON ================= */
.register-btn{
  margin-top:28px;
  height:60px;
  width:100%;
  max-width:250px;
  margin-left:auto;
  margin-right:auto;
  border-radius:14px;
  background:#f5b000;
  color:#000;
  font-weight:800;
  font-size:17px;
  border:none;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:12px;
}
.register-btn:hover{ background:#ffc93c; }

/* ================= MOBILE ================= */
@media(max-width:768px){
  #register-hero{ padding:100px 10px 60px; }
  .register-card{ padding:26px 20px; }
  .register-btn{ max-width:100%; }
}
</style>
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT']."/nestforyou/common file/header.php"; ?>

<section id="register-hero">
  <img src="/nestforyou/assets/img/hero-bg.jpg" alt="Register real estate agent">

  <div class="register-card">
    <div class="register-title">Register as an Agent</div>

    <form id="registerForm">
      <div class="row g-3">

        <div class="col-md-6 col-12">
          <input type="text" name="name" class="form-control" placeholder="Your Name" required>
        </div>

        <div class="col-md-6 col-12">
          <input type="email" name="email" class="form-control" placeholder="Your Email" required>
        </div>

        <div class="col-md-6 col-12">
          <input type="text" name="phone_number" class="form-control" placeholder="Your Number" required>
        </div>

        <div class="col-md-6 col-12">
          <select name="city" id="regCity" class="form-control" required>
            <option value="">Select City</option>
            <option value="Gurugram">Gurgaon</option>
          </select>
        </div>

        <div class="col-md-6 col-12">
          <select name="sector" id="regSector" class="form-control" required disabled>
            <option value="">Select Sector</option>
          </select>
        </div>

        <div class="col-md-6 col-12">
          <select name="apartment" id="regApartment" class="form-control" disabled>
            <option value="">Apartment (optional)</option>
          </select>
          <div id="regAptHelp" class="register-help">
            Select city and sector to load apartments.
          </div>
        </div>

      </div>

      <button type="submit" class="register-btn">
        <i class="bi bi-send"></i> submit
      </button>

      <div id="regMsg" class="mt-3 text-center fw-bold"></div>
    </form>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/nestforyou/common file/footer.php"; ?>

<script src="/nestforyou/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
/* ================= LOAD SECTORS ================= */
async function fillSector(city, select){
  select.innerHTML='<option value="">Select Sector</option>';
  select.disabled=true;
  if(!city) return;

  const fd=new FormData();
  fd.append("city",city);
  const res=await fetch("/get-sectors.php",{method:"POST",body:fd});
  const data=await res.json();
  if(data.status!=="success") return;

  data.data.forEach(v=>{
    const opt=document.createElement("option");
    opt.value=v.slug||v;
    opt.textContent=v.label||v;
    select.appendChild(opt);
  });
  select.disabled=false;
}

/* ================= LOAD APARTMENTS ================= */
async function fillApartment(city,sector){
  regApartment.innerHTML='<option value="">Apartment (optional)</option>';
  regApartment.disabled=true;
  if(!city||!sector) return;

  const fd=new FormData();
  fd.append("city",city);
  fd.append("sector",sector);
  const res=await fetch("/get-apartments.php",{method:"POST",body:fd});
  const data=await res.json();
  if(data.status!=="success") return;

  data.data.forEach(v=>{
    const opt=document.createElement("option");
    opt.value=v.slug||v;
    opt.textContent=v.label||v;
    regApartment.appendChild(opt);
  });
  regApartment.disabled=false;
}

regCity.addEventListener("change",()=>fillSector(regCity.value,regSector));
regSector.addEventListener("change",()=>fillApartment(regCity.value,regSector.value));

/* ================= FORCE DROPDOWN DOWN ================= */
function forceDropdownDown(selectEl){
  if(!selectEl) return;
  selectEl.addEventListener("mousedown",function(){
    const rect=selectEl.getBoundingClientRect();
    const spaceBelow=window.innerHeight-rect.bottom;
    if(spaceBelow<320){
      window.scrollTo({
        top:(window.pageYOffset+rect.top-150),
        behavior:"smooth"
      });
    }
  });
}

document.addEventListener("DOMContentLoaded",function(){
  forceDropdownDown(regSector);
  forceDropdownDown(regApartment);
});

/* ================= SUBMIT ================= */
registerForm.addEventListener("submit",async e=>{
  e.preventDefault();
  const fd=new FormData(registerForm);
  fd.append("action","register_agent");

  const res=await fetch("/index.php",{method:"POST",body:fd});
  const data=await res.json();
  regMsg.textContent=data.message;
  regMsg.style.color=data.status==="success"?"#f5b000":"#ff6b6b";
});
</script>

</body>
</html>
