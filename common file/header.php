<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* ================= HEADER ================= */
.header{
  background:#000;
  padding:14px 0;
  z-index:1000;
}

.logo img{ height:36px; margin-right:8px; }
.logo h1{ color:#fff; font-size:24px; margin:0; }
.logo span{ color:#f5b000; font-size:26px; }

/* Desktop nav spacing (DO NOT force display on mobile) */
@media (min-width:1200px){
  .navmenu ul{
    display:flex;
    align-items:center;
    gap:20px;
    list-style:none;
    margin:0;
    padding:0;
  }
  .navmenu a{
    color:#fff;
    text-decoration:none;
    font-size:15px;
  }
  .navmenu a.active,
  .navmenu a:hover{ color:#f5b000; }

  /* Dropdown desktop */
  .navmenu .dropdown{ position:relative; }
  .navmenu .dropdown ul{
    display:none;
    position:absolute;
    top:100%;
    left:0;
    min-width:190px;
    background:#fff;
    border-radius:8px;
    padding:10px 0;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    z-index:999;
  }
  .navmenu .dropdown:hover ul{ display:block; }
  .navmenu .dropdown ul li{ padding:6px 20px; }
  .navmenu .dropdown ul li a{
    color:#000;
    font-size:14px;
    display:block;
  }
  .navmenu .dropdown ul li a:hover{ color:#f5b000; }
}

/* ================= BUTTON ================= */
.btn-getstarted{
  border:1px solid #f5b000;
  padding:8px 16px;
  border-radius:6px;
  color:#fff;
  text-decoration:none;
}
.btn-getstarted:hover{ background:#f5b000; color:#000; }

/* ================= MOBILE FIX (restores template behavior) ================= */
@media (max-width:1199px){
  /* Show hamburger properly */
  .mobile-nav-toggle{
    color:#fff;
    font-size:28px;
    line-height:0;
    cursor:pointer;
  }

  /* IMPORTANT: do NOT force ul display on mobile */
  .navmenu ul{
    display:none;
    list-style:none;
    position:absolute;
    inset:60px 20px 20px 20px;
    padding:10px 0;
    margin:0;
    border-radius:10px;
    background:#ffffff;
    overflow-y:auto;
    box-shadow:0 0 30px rgba(0,0,0,0.12);
    z-index:9998;
  }

  /* When body gets mobile-nav-active (added by main.js) */
  .mobile-nav-active .navmenu{
    position:fixed;
    inset:0;
    background:rgba(33,37,41,0.8);
    z-index:9997;
  }
  .mobile-nav-active .navmenu > ul{
    display:block;
  }
  .mobile-nav-active .mobile-nav-toggle{
    position:absolute;
    top:15px;
    right:15px;
    z-index:9999;
  }

  /* Mobile links */
  .navmenu a{
    color:#111;
    padding:12px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    text-decoration:none;
    font-size:16px;
  }
  .navmenu a:hover,
  .navmenu .active{
    background:rgba(245,176,0,0.15);
    color:#000;
  }

  /* Mobile dropdown submenu box */
  .navmenu .dropdown ul{
    position:static;
    box-shadow:none;
    border-radius:10px;
    margin:6px 14px 10px;
    padding:8px 0;
    border:1px solid rgba(0,0,0,0.08);
  }
  .navmenu .dropdown ul li{ padding:0; }
  .navmenu .dropdown ul li a{
    padding:10px 14px;
    color:#111;
    font-size:15px;
  }

  /* ✅ MOBILE: dropdown open on tap (no dependency on dropdown-active) */
  #navmenu .dropdown > ul{ display:none !important; }
  #navmenu .dropdown.dropdown-open > ul{ display:block !important; }

  /* Chevron rotate when open */
  #navmenu .dropdown > a .bi{ transition:transform .2s ease; }
  #navmenu .dropdown.dropdown-open > a .bi{ transform:rotate(180deg); }

  /* Hide header search */
  .header-search{ display:none; }
}
</style>

<!-- ================= HEADER ================= -->
<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <!-- LOGO -->
    <a href="/nestforyou/index.php" class="logo d-flex align-items-center me-auto me-lg-0">
      <img src="/nestforyou/assets/img/logo.png" alt="Nestforyou logo">
      <h1 class="sitename">Nestforyou</h1><span>.</span>
    </a>

    <!-- NAV MENU -->
    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="/nestforyou/index.php" class="active">Home</a></li>
        <li><a href="/nestforyou/real-estate/rent/index.php">Rent</a></li>
        <li><a href="/nestforyou/buy/index.php">Buy</a></li>
        <li><a href="/nestforyou/sell/index.php">Sell</a></li>
        <li><a href="/nestforyou/register-agent/index.php">Register as an agent</a></li>
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <!-- CALL BUTTON -->
    <a class="btn-getstarted call-button" href="tel:+919910780177">Call us</a>

  </div>
</header>

<!-- ================= POPUP SCRIPT ================= -->
<script>
function openPopup() {
  const p = document.getElementById('popup');
  if (p) p.style.display = 'flex';
}

function closePopup() {
  const p = document.getElementById('popup');
  if (p) p.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
  const validation = document.getElementById('validation');
  const submitBtn = document.getElementById('submitBtn');

  if (validation && submitBtn) {
    validation.addEventListener('input', function () {
      submitBtn.disabled = (validation.value !== "20");
    });
  }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const dropdownLi   = document.querySelector("#navmenu li.dropdown");
  const dropdownLink = document.querySelector("#navmenu li.dropdown > a");
  if (!dropdownLi || !dropdownLink) return;

  dropdownLink.addEventListener("click", function (e) {

    // Only on mobile width
    if (window.innerWidth > 1199) return;

    // ✅ Prevent link navigation
    e.preventDefault();

    // ✅ Stop BootstrapMade main.js from closing the mobile menu
    e.stopPropagation();
    e.stopImmediatePropagation();

    // Toggle open/close
    dropdownLi.classList.toggle("dropdown-open");
  }, true); // ✅ capture phase: runs before main.js click handlers

  // Optional: close dropdown when clicking any non-dropdown link
  document.querySelectorAll("#navmenu ul > li:not(.dropdown) > a").forEach(function(a){
    a.addEventListener("click", function(){
      if (window.innerWidth <= 1199) dropdownLi.classList.remove("dropdown-open");
    });
  });

});
</script>

