<?php
// /blogs/index.php

// Basic SEO
$page_title = "Nestforyou Blogs | Real Estate Guides, Laws & Gurgaon Insights";
$page_description = "Read Nestforyou real estate blogs: Gurgaon property insights, RERA acts, rent control, tenancy rules, and practical guides for buyers, sellers, landlords, and tenants.";
$page_keywords = "Nestforyou blogs, Gurgaon real estate blog, RERA 2016, RERA rules 2017, Haryana rent control act 1973, Delhi rent control act 1958, model tenancy act 2021, transfer of property act 1882, property guides gurgaon";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo htmlspecialchars($page_title); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">

  <!-- Favicons -->
  <link href="https://nestforyou.in/assets/img/favicon.png" rel="icon">
  <link href="https://nestforyou.in/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files (YOUR THEME) -->
  <link href="https://nestforyou.in/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://nestforyou.in/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://nestforyou.in/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://nestforyou.in/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://nestforyou.in/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File (YOUR THEME) -->
  <link href="https://nestforyou.in/assets/css/main.css" rel="stylesheet">

  <style>
    /* =======================
       ✅ ONLY CHANGE: FORCE SITE FONTS ON BLOG PAGE
       Roboto = all text
       Raleway = headings/titles
       Poppins = nav-like UI (pills/meta/buttons)
    ======================= */

    :root{
      --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
      --heading-font: "Raleway", sans-serif;
      --nav-font: "Poppins", sans-serif;
    }

    /* Force everything on this page */
    body.blog-index-page,
    body.blog-index-page *{
      font-family: var(--default-font) !important;
    }

    /* Headings + titles */
    body.blog-index-page h1,
    body.blog-index-page h2,
    body.blog-index-page h3,
    body.blog-index-page h4,
    body.blog-index-page h5,
    body.blog-index-page h6,
    body.blog-index-page .nf-hero h1,
    body.blog-index-page .nf-title,
    body.blog-index-page .nf-panel-head{
      font-family: var(--heading-font) !important;
    }

    /* Nav-like UI text */
    body.blog-index-page .nf-pill,
    body.blog-index-page .nf-pill * ,
    body.blog-index-page .nf-tag,
    body.blog-index-page .nf-meta,
    body.blog-index-page .nf-read,
    body.blog-index-page .nf-search,
    body.blog-index-page .nf-search::placeholder,
    body.blog-index-page .nf-update-date,
    body.blog-index-page .nf-update-title{
      font-family: var(--nav-font) !important;
    }

    /* =======================
       BLOG LISTING (Qaushik-style)
       + FIX: words inside pills must be BLACK
    ======================= */

    body.blog-index-page { background:#f8f9fa; }

    /* Fixed header spacing + remove white strip */
    .blog-hero-spacer{
      height: 90px;
      background:#000;
      margin:0;
      padding:0;
    }
    @media (max-width: 1199px){
      .blog-hero-spacer{ height: 75px; background:#000; }
    }

    /* Prevent any thin gap */
    main.main{ padding-top:0 !important; }
    section{ margin-top:0 !important; }

    .nf-hero{
      background: linear-gradient(135deg, #0f0f0f 0%, #1f1f1f 100%);
      color:#fff;
      border-bottom: 4px solid #f5b000;
      padding: 70px 0 55px;
    }
    .nf-hero h1{
      font-weight: 800;
      letter-spacing: .5px;
      margin:0 0 10px;
      font-size: 3rem;
      color:#fff;
    }
    .nf-hero h1 .highlight{ color:#f5b000; }
    .nf-hero p{
      margin:0;
      opacity:.9;
      font-style: italic;
      font-size: 1.05rem;
    }

    .nf-search-wrap{
      max-width: 720px;
      margin: 28px auto 0;
      position: relative;
    }
    .nf-search{
      width:100%;
      border:2px solid #f5b000;
      border-radius: 999px;
      padding: 14px 54px 14px 18px;
      outline:none;
      box-shadow: 0 6px 18px rgba(245,176,0,.18);
      font-size: 1rem;
      color:#111;
    }
    .nf-search::placeholder{ color:#666; }
    .nf-search-btn{
      position:absolute;
      right:7px;
      top:50%;
      transform: translateY(-50%);
      width:42px;
      height:42px;
      border-radius: 999px;
      border:none;
      background:#f5b000;
      color:#000;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      box-shadow: 0 6px 14px rgba(0,0,0,.2);
    }
    .nf-search-btn:hover{ filter: brightness(.95); }

    .nf-filters{
      background:#fff;
      padding: 22px 0;
      border-bottom: 1px solid rgba(0,0,0,.06);
    }
    .nf-filter-row{
      display:flex;
      gap:14px;
      flex-wrap: wrap;
      justify-content:center;
      align-items:center;
    }

    /* ✅ FIX: make pill text BLACK always */
    .nf-pill,
    .nf-pill *{
      color:#000 !important;
    }

    /* Pills style */
    .nf-pill{
      border: 1px solid rgba(0,0,0,.10);
      background:#fff;
      cursor:pointer;
      user-select:none;
      font-weight:800;
      font-size: 1rem;
      padding: 14px 26px;
      border-radius: 999px;
      transition: .18s ease;
      box-shadow: 0 10px 26px rgba(0,0,0,.08);
      min-width: 120px;
      text-align:center;
      line-height: 1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    /* Active pill */
    .nf-pill.active{
      background:#f5b000;
      border-color:#f5b000;
      color:#000 !important;
      box-shadow: 0 16px 34px rgba(245,176,0,.28);
    }

    .nf-pill:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 34px rgba(0,0,0,.12);
    }

    @media (max-width: 576px){
      .nf-pill{
        min-width:auto;
        padding: 12px 18px;
        font-size:.95rem;
      }
    }

    .nf-layout{ padding: 35px 0 55px; }

    .nf-grid{
      display:grid;
      grid-template-columns: 1fr 320px;
      gap: 24px;
    }
    @media (max-width: 992px){
      .nf-grid{ grid-template-columns: 1fr; }
    }

    .nf-panel{
      background:#fff;
      border-radius: 12px;
      box-shadow: 0 10px 24px rgba(0,0,0,.08);
      overflow:hidden;
    }
    .nf-panel-head{
      background:#0f0f0f;
      color:#fff;
      padding: 16px 18px;
      border-bottom: 3px solid #f5b000;
      font-weight:800;
    }
    .nf-panel-body{ padding: 18px; }

    .nf-card{
      border:1px solid rgba(0,0,0,.08);
      border-left: 6px solid rgba(0,0,0,.08);
      border-radius: 12px;
      overflow:hidden;
      margin-bottom: 14px;
      transition: .2s;
      cursor:pointer;
      background:#fff;
    }
    .nf-card:hover{
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(0,0,0,.10);
      border-left-color: #f5b000;
    }
    .nf-tag{
      display:inline-block;
      margin: 14px 14px 0;
      padding: 7px 12px;
      border-radius: 999px;
      font-size: .75rem;
      font-weight:800;
      letter-spacing:.5px;
      text-transform: uppercase;
      border: 1px solid rgba(0,0,0,.10);
      background: #fff;
      color:#111;
    }
    .nf-card-inner{ padding: 12px 16px 16px; }
    .nf-title{
      font-size: 1.15rem;
      font-weight: 800;
      margin: 8px 0 8px;
      color:#111;
      line-height:1.35;
    }
    .nf-excerpt{
      color:#444;
      margin:0 0 12px;
      line-height:1.6;
      font-size:.95rem;
    }
    .nf-meta{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items:center;
      justify-content: space-between;
      border-top: 1px solid rgba(0,0,0,.08);
      padding-top: 12px;
      font-size: .85rem;
      color:#555;
    }
    .nf-read{
      text-decoration:none;
      background:#0f0f0f;
      color:#fff;
      padding: 7px 12px;
      border-radius: 999px;
      font-weight:800;
      font-size:.8rem;
      transition:.2s;
    }
    .nf-read:hover{
      background:#f5b000;
      color:#000;
    }

    .nf-update{
      padding: 12px 12px;
      border-radius: 10px;
      cursor:pointer;
      transition:.2s;
      border: 1px solid rgba(0,0,0,.06);
      margin-bottom: 10px;
      background:#fff;
    }
    .nf-update:hover{
      background: rgba(245,176,0,.08);
      border-color: rgba(245,176,0,.35);
      transform: translateX(4px);
    }
    .nf-update-date{
      font-weight: 900;
      color:#b07c00;
      font-size:.78rem;
      text-transform: uppercase;
      letter-spacing:.5px;
      margin-bottom: 3px;
    }
    .nf-update-title{
      font-weight: 800;
      color:#111;
      margin:0 0 2px;
      font-size: .92rem;
      line-height:1.25;
    }
    .nf-update-excerpt{
      margin:0;
      color:#444;
      font-size:.85rem;
      line-height:1.35;
    }

    .nf-hidden{ display:none !important; }
    .nf-highlight{
      outline: 3px solid #f5b000;
      box-shadow: 0 18px 44px rgba(245,176,0,.25);
    }
  </style>
</head>

<body class="blog-index-page">

<?php
// ✅ DO NOT CHANGE HEADER
include('/home/lbm0yd8awsua/public_html/common file/header.php');
?>

<main class="main">

  <!-- Spacer because header is fixed-top -->
  <div class="blog-hero-spacer"></div> 
  
  <!-- HERO -->
  <section class="nf-hero">
    <div class="container" data-aos="fade-up">
      <h1>Nestforyou <span class="highlight">Property Blogs</span></h1>
      <p>Real estate laws, Gurgaon insights, renting guides, and practical advice for buyers, sellers, landlords & tenants.</p>

      <div class="nf-search-wrap">
        <input id="nfSearch" class="nf-search" type="text" placeholder="Search blogs: Gurgaon, rent, RERA, tenancy, registry..." aria-label="Search blogs">
        <button class="nf-search-btn" type="button" onclick="nfPerformSearch()" aria-label="Search">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- FILTERS -->
  <section class="nf-filters">
    <div class="container" data-aos="fade-up">
      <div class="nf-filter-row">
        <div class="nf-pill active" data-filter="all" onclick="nfSetFilter('all', this)">All</div>
        <div class="nf-pill" data-filter="laws" onclick="nfSetFilter('laws', this)">Acts & Laws</div>
        <div class="nf-pill" data-filter="renting" onclick="nfSetFilter('renting', this)">Renting</div>
        <div class="nf-pill" data-filter="buying" onclick="nfSetFilter('buying', this)">Buying</div>
        <div class="nf-pill" data-filter="selling" onclick="nfSetFilter('selling', this)">Selling</div>
        <div class="nf-pill" data-filter="gurgaon" onclick="nfSetFilter('gurgaon', this)">Gurgaon</div>
      </div>
    </div>
  </section>

  <!-- CONTENT -->
  <section class="nf-layout">
    <div class="container">
      <div class="nf-grid">

        <!-- LEFT: Articles -->
        <div class="nf-panel">
          <div class="nf-panel-head" id="nfHeadTitle">Featured Articles</div>
          <div class="nf-panel-body" id="nfArticles">

            <!-- ✅ NEW ARTICLE ADDED -->
            <div class="nf-card"
                 data-category="gurgaon"
                 data-date="2026-01-23"
                 data-url="/blogs/premium-homes-to-global-experiences.php"
                 onclick="nfGo(this)">
              <div class="nf-tag">Gurgaon</div>
              <div class="nf-card-inner">
                <div class="nf-title">From Premium Homes to Global Experiences: How Luxury Travel Fits Modern Lifestyle Buyers</div>
                <p class="nf-excerpt">How experience-led luxury is reshaping lifestyle decisions for premium buyers—and why curated travel fits the modern luxury mindset.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 2026-01-23 • <i class="bi bi-clock"></i> 7 min</span>
                  <a class="nf-read" href="/blogs/premium-homes-to-global-experiences.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>
            <!-- ✅ NEW BLOG: Remodeling & Construction -->
<div class="nf-card"
     data-category="buying"
     data-date="2026-01-28"
     data-url="/blogs/remodeling-construction.php"
     onclick="nfGo(this)">
  <div class="nf-tag">Buying</div>
  <div class="nf-card-inner">
    <div class="nf-title">Kitchen Remodeling That Adds Real Value: A Practical Homeowner Guide (2026)</div>
    <p class="nf-excerpt">Plan a kitchen remodel the right way—layout, storage, lighting, durability, contractor checklist, and value decisions that matter.</p>
    <div class="nf-meta">
      <span><i class="bi bi-calendar3"></i> 2026-01-28 • <i class="bi bi-clock"></i> 9 min</span>
      <a class="nf-read" href="/blogs/remodeling-construction.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
    </div>
  </div>
</div>
<!-- ✅ Digital Marketing Agency Blog -->
<div class="nf-card"
     data-category="buying"
     data-date="2026-01-28"
     data-url="/blogs/digital-marketing-agency.php"
     onclick="nfGo(this)">
  <div class="nf-tag">Marketing</div>
  <div class="nf-card-inner">
    <div class="nf-title">
      Why Real Estate Brands Need a Digital Marketing Agency in 2026 (Not Just Ads)
    </div>
    <p class="nf-excerpt">
      SEO, Google Business Profile, local intent, and lead-quality tracking —
      a practical 2026 playbook for real estate brands that want consistent,
      high-intent enquiries instead of random leads.
    </p>
    <div class="nf-meta">
      <span>
        <i class="bi bi-calendar3"></i> 2026-01-28 •
        <i class="bi bi-clock"></i> 9 min
      </span>
      <a class="nf-read"
         href="/blogs/digital-marketing-agency.php"
         onclick="event.stopPropagation()"
         target="_blank"
         rel="noopener">
        Read
      </a>
    </div>
  </div>
</div>
<!-- ✅ Best Dentist in Chembur Blog -->
<div class="nf-card"
     data-category="gurgaon"
     data-date="2026-01-28"
     data-url="/blogs/best-dentist-in-chembur.php"
     onclick="nfGo(this)">
  <div class="nf-tag">Healthcare</div>
  <div class="nf-card-inner">
    <div class="nf-title">
      Best Dentist in Chembur: How to Choose the Right Clinic (2026 Guide)
    </div>
    <p class="nf-excerpt">
      A practical, non-promotional guide to finding the best dentist in Chembur —
      what to check, common treatments, pricing signals, and red flags to avoid.
    </p>
    <div class="nf-meta">
      <span>
        <i class="bi bi-calendar3"></i> 2026-01-28 •
        <i class="bi bi-clock"></i> 8 min
      </span>
      <a class="nf-read"
         href="/blogs/best-dentist-in-chembur.php"
         onclick="event.stopPropagation()"
         target="_blank"
         rel="noopener">
        Read
      </a>
    </div>
  </div>
</div>

            <div class="nf-card" data-category="laws" data-date="2016-03-25" data-url="/blogs/rera-2016/chapters.php" onclick="nfGo(this)">
              <div class="nf-tag">Acts & Laws</div>
              <div class="nf-card-inner">
                <div class="nf-title">The Real Estate (Regulation and Development) Act, 2016 (RERA) — Chapters & Key Provisions</div>
                <p class="nf-excerpt">Understand how RERA protects buyers, regulates builders, and improves transparency in Indian real estate.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 2016-03-25 • <i class="bi bi-clock"></i> 8 min</span>
                  <a class="nf-read" href="/blogs/rera-2016/chapters.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="laws" data-date="2017-04-28" data-url="/blogs/rera-2017/chapters.php" onclick="nfGo(this)">
              <div class="nf-tag">Acts & Laws</div>
              <div class="nf-card-inner">
                <div class="nf-title">The Real Estate (Regulation and Development) Rules, 2017 — What Changed After RERA</div>
                <p class="nf-excerpt">A practical view of RERA Rules 2017: compliance, registrations, and what consumers should check.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 2017-04-28 • <i class="bi bi-clock"></i> 7 min</span>
                  <a class="nf-read" href="/blogs/rera-2017/chapters.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="laws" data-date="1973-01-01" data-url="/blogs/haryana-urban-rent-control-act.php" onclick="nfGo(this)">
              <div class="nf-tag">Acts & Laws</div>
              <div class="nf-card-inner">
                <div class="nf-title">The Haryana Urban (Control of Rent and Eviction) Act, 1973 — Explained for Tenants & Landlords</div>
                <p class="nf-excerpt">Key sections that impact rent, eviction, disputes, and landlord/tenant rights in Haryana.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 1973-01-01 • <i class="bi bi-clock"></i> 6 min</span>
                  <a class="nf-read" href="/blogs/haryana-urban-rent-control-act.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="laws" data-date="1958-01-01" data-url="/blogs/delhi-rent-control-act/chapters.php" onclick="nfGo(this)">
              <div class="nf-tag">Acts & Laws</div>
              <div class="nf-card-inner">
                <div class="nf-title">The Delhi Rent Control Act, 1958 — Chapters & Key Rules</div>
                <p class="nf-excerpt">A structured chapter-wise reading for anyone renting, letting, or managing property in Delhi.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 1958-01-01 • <i class="bi bi-clock"></i> 6 min</span>
                  <a class="nf-read" href="/blogs/delhi-rent-control-act/chapters.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="renting" data-date="2021-01-01" data-url="/blogs/model-tenancy-act-2021/chapters.php" onclick="nfGo(this)">
              <div class="nf-tag">Renting</div>
              <div class="nf-card-inner">
                <div class="nf-title">Model Tenancy Act, 2021 — What It Means for Rent Agreements in India</div>
                <p class="nf-excerpt">Security deposit, timelines, dispute resolution, and what tenants/landlords should include in agreements.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 2021-01-01 • <i class="bi bi-clock"></i> 7 min</span>
                  <a class="nf-read" href="/blogs/model-tenancy-act-2021/chapters.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="buying" data-date="1882-01-01" data-url="/blogs/transfer-of-property-act-1882/chapters.php" onclick="nfGo(this)">
              <div class="nf-tag">Buying</div>
              <div class="nf-card-inner">
                <div class="nf-title">Transfer of Property Act, 1882 — A Buyer’s Guide to Ownership Transfer Basics</div>
                <p class="nf-excerpt">Understand transfer, sale, gift, mortgage basics and what documents matter during property purchase.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 1882-01-01 • <i class="bi bi-clock"></i> 8 min</span>
                  <a class="nf-read" href="/blogs/transfer-of-property-act-1882/chapters.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Read</a>
                </div>
              </div>
            </div>

            <div class="nf-card" data-category="gurgaon" data-date="2026-01-01" data-url="/contact/real-estate-agents/gurgaon.php" onclick="nfGo(this)">
              <div class="nf-tag">Gurgaon</div>
              <div class="nf-card-inner">
                <div class="nf-title">Need a Verified Real Estate Agent in Gurgaon? Start Here</div>
                <p class="nf-excerpt">Browse Gurgaon agent contacts by sector and society pages inside Nestforyou — faster calls, less spam.</p>
                <div class="nf-meta">
                  <span><i class="bi bi-calendar3"></i> 2026-01-01 • <i class="bi bi-clock"></i> 4 min</span>
                  <a class="nf-read" href="/contact/real-estate-agents/gurgaon.php" onclick="event.stopPropagation()" target="_blank" rel="noopener">Open</a>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- RIGHT: Latest Updates -->
        <aside class="nf-panel">
          <div class="nf-panel-head">Latest Updates</div>
          <div class="nf-panel-body" id="nfLatest"></div>
        </aside>

      </div>
    </div>
  </section>

</main>

<?php
// ✅ DO NOT CHANGE FOOTER
include('/home/lbm0yd8awsua/public_html/common file/footer.php');
?>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files (YOUR THEME) -->
<script src="https://nestforyou.in/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://nestforyou.in/assets/vendor/php-email-form/validate.js"></script>
<script src="https://nestforyou.in/assets/vendor/aos/aos.js"></script>
<script src="https://nestforyou.in/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="https://nestforyou.in/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="https://nestforyou.in/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="https://nestforyou.in/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="https://nestforyou.in/assets/vendor/purecounter/purecounter_vanilla.js"></script>

<!-- Main JS File (YOUR THEME) -->
<script src="https://nestforyou.in/assets/js/main.js"></script>

<script>
  let nfFilter = 'all';

  function nfGo(el){
    const url = el.getAttribute('data-url');
    if(url) window.location.href = url;
  }

  function nfSetFilter(filter, pill){
    nfFilter = filter;

    document.querySelectorAll('.nf-pill').forEach(p => p.classList.remove('active'));
    pill.classList.add('active');

    const s = document.getElementById('nfSearch');
    if(s) s.value = '';

    nfApply();
    nfBuildLatest();
    window.scrollTo({ top: document.querySelector('.nf-layout').offsetTop - 30, behavior:'smooth' });
  }

  function nfPerformSearch(){
    nfApply(true);
    nfBuildLatest();
  }

  function nfApply(fromButton=false){
    const term = (document.getElementById('nfSearch')?.value || '').trim().toLowerCase();
    const cards = document.querySelectorAll('.nf-card');

    let visible = 0;
    let firstMatch = null;

    cards.forEach(card => {
      const cat = (card.getAttribute('data-category') || '').toLowerCase();

      const catOk = (nfFilter === 'all') ? true : (cat === nfFilter);
      const text = (card.innerText || '').toLowerCase();
      const searchOk = term ? text.includes(term) : true;

      if(catOk && searchOk){
        card.classList.remove('nf-hidden');
        visible++;
        if(!firstMatch && term) firstMatch = card;
      } else {
        card.classList.add('nf-hidden');
      }

      card.classList.remove('nf-highlight');
    });

    const head = document.getElementById('nfHeadTitle');
    if(head){
      if(term){
        head.textContent = `Search Results for "${term}" (${visible})`;
      } else if(nfFilter !== 'all'){
        head.textContent = `${nfFilter.charAt(0).toUpperCase() + nfFilter.slice(1)} (${visible})`;
      } else {
        head.textContent = `Featured Articles (${visible})`;
      }
    }

    if(firstMatch && fromButton){
      firstMatch.classList.add('nf-highlight');
      firstMatch.scrollIntoView({ behavior:'smooth', block:'center' });
      setTimeout(()=> firstMatch.classList.remove('nf-highlight'), 2500);
    }
  }

  function nfBuildLatest(){
    const latestWrap = document.getElementById('nfLatest');
    if(!latestWrap) return;

    const cards = [...document.querySelectorAll('.nf-card')].filter(c => !c.classList.contains('nf-hidden'));

    const items = cards.map(c => {
      const title = (c.querySelector('.nf-title')?.textContent || '').trim();
      const excerpt = (c.querySelector('.nf-excerpt')?.textContent || '').trim();
      const date = c.getAttribute('data-date') || '2000-01-01';
      const url = c.getAttribute('data-url') || '#';
      return { title, excerpt, date, url };
    });

    items.sort((a,b) => (a.date < b.date ? 1 : -1));
    latestWrap.innerHTML = '';

    const top5 = items.slice(0,5);
    if(top5.length === 0){
      latestWrap.innerHTML = '<div style="color:#666;font-style:italic;">No articles found.</div>';
      return;
    }

    top5.forEach(it => {
      const div = document.createElement('div');
      div.className = 'nf-update';
      div.onclick = () => window.location.href = it.url;
      div.innerHTML = `
        <div class="nf-update-date">${it.date}</div>
        <div class="nf-update-title">${it.title}</div>
        <p class="nf-update-excerpt">${(it.excerpt || '').slice(0,100)}...</p>
      `;
      latestWrap.appendChild(div);
    });
  }

  document.addEventListener('DOMContentLoaded', function(){
    const s = document.getElementById('nfSearch');
    if(s){
      s.addEventListener('keydown', function(e){
        if(e.key === 'Enter'){ nfPerformSearch(); }
      });
      s.addEventListener('input', function(){
        nfApply(false);
        nfBuildLatest();
      });
    }

    nfApply(false);
    nfBuildLatest();
  });
</script>

</body>
</html>
