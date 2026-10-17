// ============================================================
// SEARCH.JS — MASTER PRODUCT CATALOG (NO localStorage)
// Works from ANY page: Home, Occasions, About, etc.
// ============================================================

// =============================
// 🌸 MASTER PRODUCT DATABASE
// =============================
const masterCatalog = [
  // === ROSES (rose.js) ===
  { id: "rose-blue-sapphire",   title: "Blue Sapphire Roses", kurdishTitle: "گولی سەفیر شین",         category: "Roses",      price: "20.00",  image: "assets/img/items/roses/rose_1.jpg",  link: "details.php?id=rose-blue-sapphire" },
  { id: "rose-rainbow-romance", title: "Rainbow Romance Roses", kurdishTitle: "گولی ڕەنگاو ڕۆمانس",       category: "Roses",      price: "25.00",  image: "assets/img/items/roses/rose_2.jpg",  link: "details.php?id=rose-rainbow-romance" },
  { id: "rose-golden-sunshine", title: "Golden Sunshine Roses", kurdishTitle: "گولی زێڕینی خۆر",       category: "Roses",      price: "19.00",  image: "assets/img/items/roses/rose_3.jpg",  link: "details.php?id=rose-golden-sunshine" },
  { id: "rose-ruby-red",        title: "Ruby Red Romance", kurdishTitle: "گولی ڕوبی سوور ڕۆمانس",            category: "Roses",      price: "24.00",  image: "assets/img/items/roses/rose_5.jpg",  link: "details.php?id=rose-ruby-red" },
  { id: "rose-peach-paradise",  title: "Peach Paradise Roses", kurdishTitle: "گولی پێچ پارادایز",        category: "Roses",      price: "20.00",  image: "assets/img/items/roses/rose_6.jpg",  link: "details.php?id=rose-peach-paradise" },
  { id: "rose-blush-pink",      title: "Blush Pink Dream", kurdishTitle: "گولی پینکی بلاش درێم",            category: "Roses",      price: "21.00",  image: "assets/img/items/roses/rose_7.jpg",  link: "details.php?id=rose-blush-pink" },
  { id: "rose-pure-white",      title: "Pure White Elegance", kurdishTitle: "گولی سپی پاک و جوان",         category: "Roses",      price: "28.00",  image: "assets/img/items/roses/rose_9.jpg",  link: "details.php?id=rose-pure-white" },
  { id: "rose-soft-pink",       title: "Soft Pink Ribbon Roses", kurdishTitle: "گولی پینکی نەرم و ڕیبۆن",      category: "Roses",      price: "20.00",  image: "assets/img/items/roses/rose_10.jpg", link: "details.php?id=rose-soft-pink" },

  // === TULIPS (tulip.js) ===
  { id: "tulip-rainbow",        title: "Rainbow Mixed Tulips", kurdishTitle: "گولی تیولیپ ڕەنگاو",        category: "Tulips",     price: "17.00",  image: "assets/img/items/tulips/tulip_1.jpg", link: "details.php?id=tulip-rainbow" },
  { id: "tulip-red-white",      title: "Red & White Romance Tulips", kurdishTitle: "گولی تیولیپ سوور و سپی ڕۆمانس",  category: "Tulips",     price: "22.00",  image: "assets/img/items/tulips/tulip_2.jpg", link: "details.php?id=tulip-red-white" },
  { id: "tulip-pure-white",     title: "Pure White Elegance Tulips", kurdishTitle: "گولی تیولیپ سپی پاک و جوان",  category: "Tulips",     price: "19.00",  image: "assets/img/items/tulips/tulip_3.jpg", link: "details.php?id=tulip-pure-white" },
  { id: "tulip-lavender",       title: "Lavender Love Tulips", kurdishTitle: "گولی تیولیپ لاڤەندەر خۆشەویستی",        category: "Tulips",     price: "19.00",  image: "assets/img/items/tulips/tulip_5.jpg", link: "details.php?id=tulip-lavender" },
  { id: "tulip-ruby-red",       title: "Ruby Red Tulip Bouquet", kurdishTitle: "گولی تیولیپ ڕوبی سوور",      category: "Tulips",     price: "24.00",  image: "assets/img/items/tulips/tulip_6.jpg", link: "details.php?id=tulip-ruby-red" },
  { id: "tulip-blush-pink",     title: "Blush Pink Tulip Bouquet", kurdishTitle: "گولی تیولیپ پینکی بلاش",    category: "Tulips",     price: "20.00",  image: "assets/img/items/tulips/tulip_8.jpg", link: "details.php?id=tulip-blush-pink" },

  // === LILIES (lily.js) ===
  { id: "lily-sunset-orange",   title: "Sunset Orange Tiger Lilies", kurdishTitle: "گولی لیلیی ئۆرنجی غرووبی خۆر",  category: "Lilies",     price: "25.00",  image: "assets/img/items/lilys/lily_2.jpg",  link: "details.php?id=lily-sunset-orange" },
  { id: "lily-pink-galaxy",     title: "Pink Galaxy Stargazer Lilies", kurdishTitle: "گولی لیلیی پینکی گەلاکسی",category: "Lilies",     price: "22.00",  image: "assets/img/items/lilys/lily_4.jpg",  link: "details.php?id=lily-pink-galaxy" },
  { id: "lily-blush-pink",      title: "Blush Pink Bouquet Lilies", kurdishTitle: "گولی لیلیی پینکی بلاش",   category: "Lilies",     price: "27.00",  image: "assets/img/items/lilys/lily_6.jpg",  link: "details.php?id=lily-blush-pink" },
  { id: "lily-white-heaven",    title: "White Heaven Lilies", kurdishTitle: "گولی لیلیی سپی بەهەشت",         category: "Lilies",     price: "20.00",  image: "assets/img/items/lilys/lily_7.jpg",  link: "details.php?id=lily-white-heaven" },
  { id: "lily-ocean-blue",      title: "Ocean Blue Magic Lilies", kurdishTitle: "گولی لیلیی شینی ئۆقیانوس",     category: "Lilies",     price: "27.00",  image: "assets/img/items/lilys/lily_9.jpg",  link: "details.php?id=lily-ocean-blue" },
  { id: "lily-pastel-dream",    title: "Pastel Pink Dream Lilies", kurdishTitle: "گولی لیلیی پاستێلی پینکی خەون",    category: "Lilies",     price: "30.00",  image: "assets/img/items/lilys/lily_10.jpg", link: "details.php?id=lily-pastel-dream" },

  // === SUNFLOWERS (sunflower.js) ===
  { id: "sunflower-classic",      title: "Classic Yellow Sunflower Bouquet", kurdishTitle: "گولی گەرداڵەی زەردی کلاسیک", category: "Sunflowers", price: "14.00", image: "assets/img/items/sunflowers/sunflower_2.jpg",  link: "details.php?id=sunflower-classic" },
  { id: "sunflower-sunny-basket", title: "Sunny Day Basket", kurdishTitle: "سەبەتەی گەرداڵەی ڕۆژەکی خۆر",               category: "Sunflowers", price: "17.00", image: "assets/img/items/sunflowers/sunflower_3.jpg",  link: "details.php?id=sunflower-sunny-basket" },
  { id: "sunflower-golden-vase",  title: "Golden Vase Arrangement", kurdishTitle: "گولی گەرداڵەی زێڕینی مزە",        category: "Sunflowers", price: "22.00", image: "assets/img/items/sunflowers/sunflower_4.jpg",  link: "details.php?id=sunflower-golden-vase" },
  { id: "sunflower-giant-heart",  title: "Giant Sunflower Heart", kurdishTitle: "دڵی گەرداڵەی گەورە",          category: "Sunflowers", price: "28.00", image: "assets/img/items/sunflowers/sunflower_6.jpg",  link: "details.php?id=sunflower-giant-heart" },
  { id: "sunflower-elegant",      title: "Elegant Wrapped Sunflowers", kurdishTitle: "گولی گەرداڵەی جوان پێچراو",     category: "Sunflowers", price: "20.00", image: "assets/img/items/sunflowers/sunflower_10.jpg", link: "details.php?id=sunflower-elegant" },

  // === DAISIES (daisy.js) ===
  { id: "daisy-golden",      title: "Golden Daisy Sunshine", kurdishTitle: "گولی دەیزی زێڕینی خۆر",   category: "Daisies", price: "17.00", image: "assets/img/items/daisies/beautifuldaisy.jpg",   link: "details.php?id=daisy-golden" },
  { id: "daisy-pure-white",  title: "Pure White Daisy Bloom", kurdishTitle: "گولی دەیزی سپی پاک",  category: "Daisies", price: "20.00", image: "assets/img/items/daisies/daisies.jpg",          link: "details.php?id=daisy-pure-white" },
  { id: "daisy-soft-charm",  title: "Soft Daisy Charm", kurdishTitle: "گولی دەیزی نەرم و جوانی",        category: "Daisies", price: "20.00", image: "assets/img/items/daisies/daisy.jpg",            link: "details.php?id=daisy-soft-charm" },
  { id: "daisy-blue-magic",  title: "Blue Daisy Magic", kurdishTitle: "گولی دەیزی شینی جادوویی",        category: "Daisies", price: "26.00", image: "assets/img/items/daisies/prettybluedaisy.jpg",  link: "details.php?id=daisy-blue-magic" },
  { id: "daisy-rosy-garden", title: "Rosy Daisy Garden", kurdishTitle: "گولی دەیزی ڕۆزی باخچە",       category: "Daisies", price: "20.00", image: "assets/img/items/daisies/rosiedaisie.jpg",      link: "details.php?id=daisy-rosy-garden" },
  { id: "daisy-simple-white",title: "Simple White Daisy Wrap", kurdishTitle: "گولی دەیزی سپی سادە", category: "Daisies", price: "17.00", image: "assets/img/items/daisies/whitedaisy.jpg",       link: "details.php?id=daisy-simple-white" },

  // === ORCHIDS (orchids.js) ===
  { id: "orchid-purple-majesty", title: "Purple Majesty Orchids", kurdishTitle: "گولی ئۆرکید مۆر شاهانە",    category: "Orchids", price: "30.00", image: "assets/img/items/orchids/orchid_1.jpg",  link: "details.php?id=orchid-purple-majesty" },
  { id: "orchid-pink-champagne", title: "Pink Champagne Orchids", kurdishTitle: "گولی ئۆرکید پینکی شەمپاین",    category: "Orchids", price: "28.00", image: "assets/img/items/orchids/orchid_5.jpg",  link: "details.php?id=orchid-pink-champagne" },
  { id: "orchid-sunset-coral",   title: "Sunset Coral Orchids", kurdishTitle: "گولی ئۆرکید کۆرالی غرووبی خۆر",      category: "Orchids", price: "30.00", image: "assets/img/items/orchids/orchid_6.jpg",  link: "details.php?id=orchid-sunset-coral" },
  { id: "orchid-pink-cascade",   title: "Pink Cascade Orchids", kurdishTitle: "گولی ئۆرکید پینکی کاسکید",      category: "Orchids", price: "28.00", image: "assets/img/items/orchids/orchid_7.jpg",  link: "details.php?id=orchid-pink-cascade" },
  { id: "orchid-golden-sunrise", title: "Golden Sunrise Orchids", kurdishTitle: "گولی ئۆرکید زێڕینی هەڵاتنی خۆر",    category: "Orchids", price: "22.00", image: "assets/img/items/orchids/orchid_9.jpg",  link: "details.php?id=orchid-golden-sunrise" },
  { id: "orchid-ocean-breeze",   title: "Ocean Breeze Blue Orchids", kurdishTitle: "گولی ئۆرکید شینی نسیمی ئۆقیانوس", category: "Orchids", price: "35.00", image: "assets/img/items/orchids/orchid_10.jpg", link: "details.php?id=orchid-ocean-breeze" },

  // === MINI ROSES (minirose.js) ===
  { id: "minirose-crimson",      title: "Crimson Mini Rose Bouquet", kurdishTitle: "گولی مینی ڕۆز کریمسۆن", category: "Mini Roses", price: "17.00", image: "assets/img/items/minirose/redminirose.jpg",      link: "details.php?id=minirose-crimson" },
  { id: "minirose-pinky-baby",   title: "Pinky Baby Rose Wrap", kurdishTitle: "گولی مینی پینکی منداڵ",      category: "Mini Roses", price: "14.00", image: "assets/img/items/minirose/pinkybabyrosie.jpg",   link: "details.php?id=minirose-pinky-baby" },
  { id: "minirose-pretty-pink",  title: "Pretty Pink Rosie Bunch", kurdishTitle: "گولی مینی پینکی جوان",   category: "Mini Roses", price: "20.00", image: "assets/img/items/minirose/prettypinkyrosie.jpg", link: "details.php?id=minirose-pretty-pink" },
  { id: "minirose-ocean-peach",  title: "Ocean Peach Rosie Bouquet", kurdishTitle: "گولی مینی پێچی ئۆقیانوس", category: "Mini Roses", price: "19.00", image: "assets/img/items/minirose/oceanrosie.jpg",       link: "details.php?id=minirose-ocean-peach" },
  { id: "minirose-golden-sunset",title: "Golden Sunset Rosie", kurdishTitle: "گولی مینی زێڕینی غرووبی خۆر",       category: "Mini Roses", price: "22.00", image: "assets/img/items/minirose/goldenrosie.jpg",      link: "details.php?id=minirose-golden-sunset" },
  { id: "minirose-fairy-white",  title: "Fairy White Rosie Bouquet", kurdishTitle: "گولی مینی سپی پەری", category: "Mini Roses", price: "16.00", image: "assets/img/items/minirose/fairywhiterosie.jpg",  link: "details.php?id=minirose-fairy-white" },

  // === BUTTERCUPS (buttercup.js) ===
  { id: "buttercup-golden", title: "Golden Buttercup Bouquet", kurdishTitle: "گولی باتەرکاپ زێڕین",     category: "Buttercup", price: "14.00", image: "assets/img/items/buttercup/buttercup.jpg",         link: "details.php?id=buttercup-golden" },
  { id: "buttercup-cream",  title: "Cream & Gold Buttercup Wrap", kurdishTitle: "گولی باتەرکاپ کریم و زێڕ",  category: "Buttercup", price: "16.00", image: "assets/img/items/buttercup/buttercup6.jpg",        link: "details.php?id=buttercup-cream" },
  { id: "buttercup-modern", title: "Modern Buttercup Arrangement", kurdishTitle: "گولی باتەرکاپ مۆدێرن", category: "Buttercup", price: "22.00", image: "assets/img/items/buttercup/modernbuttercup.jpg",   link: "details.php?id=buttercup-modern" },
  { id: "buttercup-sunset", title: "Sunset Orange Buttercup", kurdishTitle: "گولی باتەرکاپ ئۆرنجی غرووب",      category: "Buttercup", price: "17.00", image: "assets/img/items/buttercup/orangebuttercup.jpg",   link: "details.php?id=buttercup-sunset" },
  { id: "buttercup-rosy",   title: "Rosy Pink Buttercup Bundle", kurdishTitle: "گولی باتەرکاپ پینکی ڕۆزی",   category: "Buttercup", price: "14.00", image: "assets/img/items/buttercup/pinkbuttercup.jpg",     link: "details.php?id=buttercup-rosy" },

  // === DAFFODILS (daffodils.js) ===
  { id: "daffodil-baby",        title: "Baby Spring Daffodils", kurdishTitle: "گولی دەفۆدیل منداڵی بەهار",    category: "Daffodils", price: "16.00", image: "assets/img/items/daffodils/babydaffoldis.jpg",         link: "details.php?id=daffodil-baby" },
  { id: "daffodil-classic",     title: "Classic Yellow Daffodils", kurdishTitle: "گولی دەفۆدیل زەردی کلاسیک", category: "Daffodils", price: "17.00", image: "assets/img/items/daffodils/daffoldilsss.jpg",          link: "details.php?id=daffodil-classic" },
  { id: "daffodil-golden",      title: "Golden Spring Elegance", kurdishTitle: "گولی دەفۆدیل زێڕینی بەهار",   category: "Daffodils", price: "19.00", image: "assets/img/items/daffodils/gorgousdaffoldils.jpg",     link: "details.php?id=daffodil-golden" },
  { id: "daffodil-lavender",    title: "Lavender Sunshine Mix", kurdishTitle: "گولی دەفۆدیل لاڤەندەر خۆر",    category: "Daffodils", price: "22.00", image: "assets/img/items/daffodils/lavenderdaffoldils.jpg",    link: "details.php?id=daffodil-lavender" },
  { id: "daffodil-lightyellow", title: "Light Yellow Dream", kurdishTitle: "گولی دەفۆدیل زەردی سووک",       category: "Daffodils", price: "17.00", image: "assets/img/items/daffodils/lightyellowdaffoldils.jpg", link: "details.php?id=daffodil-lightyellow" },

  // === MIXED BOUQUETS (mixed_flower.js) ===
  { id: "mixed-pink-garden",      title: "Pink Garden Delight", kurdishTitle: "بوکێتی باخچەی پینکی",     category: "Mixed", price: "22.00", image: "assets/img/items/mixed/mixed_1.jpg",  link: "details.php?id=mixed-pink-garden" },
  { id: "mixed-sweet-blossom",    title: "Sweet Blossom Dream", kurdishTitle: "خەونی گوڵی شیرین",     category: "Mixed", price: "25.00", image: "assets/img/items/mixed/mixed_2.jpg",  link: "details.php?id=mixed-sweet-blossom" },
  { id: "mixed-white-daisy",      title: "White Daisy Charm", kurdishTitle: "جوانی دەیزی سپی",       category: "Mixed", price: "28.00", image: "assets/img/items/mixed/mixed_3.jpg",  link: "details.php?id=mixed-white-daisy" },
  { id: "mixed-soft-pastel",      title: "Soft Pastel Love", kurdishTitle: "خۆشەویستی پاستێلی نەرم",        category: "Mixed", price: "27.00", image: "assets/img/items/mixed/mixed_6.jpg",  link: "details.php?id=mixed-soft-pastel" },
  { id: "mixed-lavender-whisper", title: "Lavender Whisper", kurdishTitle: "نسیمی لاڤەندەر",        category: "Mixed", price: "20.00", image: "assets/img/items/mixed/mixed_7.jpg",  link: "details.php?id=mixed-lavender-whisper" },
  { id: "mixed-spring-morning",   title: "Spring Morning Glow", kurdishTitle: "ڕوناکی بەیانی بەهار",     category: "Mixed", price: "27.00", image: "assets/img/items/mixed/mixed_8.jpg",  link: "details.php?id=mixed-spring-morning" },
  { id: "mixed-blush-blossom",    title: "Blush Blossom Fantasy", kurdishTitle: "فانتازیای بلاش بلۆسم",   category: "Mixed", price: "25.00", image: "assets/img/items/mixed/mixed_9.jpg",  link: "details.php?id=mixed-blush-blossom" },
  { id: "mixed-white-elegance",   title: "White Elegance Bouquet", kurdishTitle: "بوکێتی سپی جوان",  category: "Mixed", price: "25.00", image: "assets/img/items/mixed/mixed_10.jpg", link: "details.php?id=mixed-white-elegance" },

  // === VIP BOUQUETS (vip.js) ===
  { id: "vip-1", title: "Tulip Mix Color",        category: "VIP Bouquets", price: "42.00",   image: "assets/img/items/vip/vip_1.jpg", link: "details.php?id=vip-1" },
  { id: "vip-2", title: "Tulips Bouquet",         category: "VIP Bouquets", price: "45.00",   image: "assets/img/items/vip/vip_2.jpg", link: "details.php?id=vip-2" },
  { id: "vip-3", title: "White Tulips Luxury",    category: "VIP Bouquets", price: "48.00",image: "assets/img/items/vip/vip_3.jpg", link: "details.php?id=vip-3" },
  { id: "vip-4", title: "Pink VIP Flowers",       category: "VIP Bouquets", price: "46.00", image: "assets/img/items/vip/vip_4.jpg", link: "details.php?id=vip-4" },
  { id: "vip-5", title: "Mini Rose Pink VIP",     category: "VIP Bouquets", price: "50.00",   image: "assets/img/items/vip/vip_5.jpg", link: "details.php?id=vip-5" },
  { id: "vip-6", title: "White Lily VIP Flowers", category: "VIP Bouquets", price: "$50",   image: "assets/img/items/vip/vip_6.jpg", link: "details.php?id=vip-6" },
  { id: "vip-7", title: "Ultimate VIP Flowers",   category: "VIP Bouquets", price: "48.00",image: "assets/img/items/vip/vip_7.jpg", link: "details.php?id=vip-7" },

  // === BEARS & CHOCOLATES (bearchocolate.js) ===
  { id: "bear_1",       title: "Soft Classic Teddy Bear",    category: "Gifts",     price: "22.00", image: "assets/img/items/bear/bear_1.jpg",       link: "giftdetail.php?id=bear_1" },
  { id: "bear_2",       title: "Elegant Pink Dress Bear",    category: "Gifts",     price: "22.00", image: "assets/img/items/bear/bear_2.jpg",       link: "giftdetail.php?id=bear_2" },
  { id: "bear_3",       title: "Mini Cute Bear",             category: "Gifts",     price: "14.00", image: "assets/img/items/bear/bear_3.jpg",       link: "giftdetail.php?id=bear_3" },
  { id: "bear_6",       title: "Pink Love Bear",             category: "Gifts",     price: "14.00", image: "assets/img/items/bear/bear_6.jpg",       link: "giftdetail.php?id=bear_6" },
  { id: "bear_7",       title: "Classic Brown Bear",         category: "Gifts",     price: "14.00", image: "assets/img/items/bear/bear_7.jpg",       link: "giftdetail.php?id=bear_7" },
  { id: "chocolate_1",  title: "Luxury Chocolate Box",       category: "Chocolates",price: "27.00", image: "assets/img/items/chocolate/chocolate_1.jpg", link: "giftdetail.php?id=chocolate_1" },
  { id: "chocolate_2",  title: "Heart Chocolate Box",        category: "Chocolates",price: "28.00", image: "assets/img/items/chocolate/chocolate_2.jpg", link: "giftdetail.php?id=chocolate_2" },
  { id: "chocolate_3",  title: "Strawberry Chocolate Set",   category: "Chocolates",price: "25.00", image: "assets/img/items/chocolate/chocolate_3.jpg", link: "giftdetail.php?id=chocolate_3" },
  { id: "chocolate_4",  title: "Premium Chocolate Collection",category: "Chocolates",price: "30.00", image: "assets/img/items/chocolate/chocolate_4.jpg", link: "giftdetail.php?id=chocolate_4" },
  { id: "chocolate_5",  title: "Luxury Valentine Chocolate", category: "Chocolates",price: "32.00", image: "assets/img/items/chocolate/chocolate_5.jpg", link: "giftdetail.php?id=chocolate_5" }
];

// =============================
// 🌸 SEARCH INPUT SETUP
// =============================
const searchInput = document.querySelector('.search-input');
const searchButton = document.querySelector('.search__btn');
const isSearchPage = window.location.pathname.includes("search.php");
const getIsLoggedIn = () => window.isLoggedIn === true || window.isLoggedIn === 'true' || window.lioraUserId !== null;

let cachedSearchHistory = null;

// Debug logging
const DEBUG = false; // Set to true for debugging
function debugLog(...args) {
  if (DEBUG) console.log('[SEARCH DEBUG]', ...args);
}

debugLog('Search initialized. Is search page:', isSearchPage);

// =============================
// 🌸 SMART SEARCH FUNCTION
// =============================
function findBestMatch(query) {
  const q = query.toLowerCase().trim();
  if (!q) return null;

  // 1️⃣ EXACT TITLE MATCH (case insensitive)
  const exact = masterCatalog.find(p => p.title.toLowerCase() === q || (p.kurdishTitle && p.kurdishTitle.toLowerCase() === q));
  if (exact) return exact;

  // 2️⃣ TITLE STARTS WITH QUERY
  const startsWith = masterCatalog.find(p => p.title.toLowerCase().startsWith(q) || (p.kurdishTitle && p.kurdishTitle.toLowerCase().startsWith(q)));
  if (startsWith) return startsWith;

  // 3️⃣ QUERY STARTS WITH TITLE
  const queryStartsWithTitle = masterCatalog.find(p => q.startsWith(p.title.toLowerCase()) || (p.kurdishTitle && q.startsWith(p.kurdishTitle.toLowerCase())));
  if (queryStartsWithTitle) return queryStartsWithTitle;

  // 4️⃣ TITLE INCLUDES QUERY
  const includes = masterCatalog.find(p => p.title.toLowerCase().includes(q) || (p.kurdishTitle && p.kurdishTitle.toLowerCase().includes(q)));
  if (includes) return includes;

  // 5️⃣ QUERY INCLUDES TITLE
  const includedByQuery = masterCatalog.find(p => q.includes(p.title.toLowerCase()) || (p.kurdishTitle && q.includes(p.kurdishTitle.toLowerCase())));
  if (includedByQuery) return includedByQuery;

  // 6️⃣ ALL WORDS MATCH IN ANY ORDER & ANY CASE
  const qWords = q.split(/\s+/).filter(Boolean);
  if (qWords.length > 1) {
    const allWordsMatch = masterCatalog.find(p => {
      const titleWords = p.title.toLowerCase().split(/\s+/);
      return qWords.every(w => titleWords.some(tw => tw === w || tw.includes(w) || w.includes(tw)));
    });
    if (allWordsMatch) return allWordsMatch;
  }

  // 7️⃣ CATEGORY MATCH (for broad searches like "roses", "tulips")
  const categoryMatch = masterCatalog.find(p =>
    p.category.toLowerCase() === q || p.category.toLowerCase().includes(q)
  );
  if (categoryMatch) return { isCategory: true, category: categoryMatch.category };

  return null;
}

// =============================
// 🌸 FIND ALL MATCHING PRODUCTS
// =============================
function findAllMatches(query) {
  const q = query.toLowerCase().trim();
  if (!q) return [];

  const qWords = q.split(/\s+/).filter(Boolean);

  return masterCatalog.filter(p => {
    const title = p.title.toLowerCase();
    const category = p.category.toLowerCase();
    const fullText = title + " " + category + " " + (p.kurdishTitle ? p.kurdishTitle.toLowerCase() : "");

    // Check if all query words appear somewhere in title or category
    return qWords.every(word => fullText.includes(word));
  }).sort((a, b) => {
    // Sort by relevance: exact matches first, then starts with, then includes
    const aTitle = a.title.toLowerCase();
    const bTitle = b.title.toLowerCase();

    if (aTitle === q && bTitle !== q) return -1;
    if (bTitle === q && aTitle !== q) return 1;
    if (aTitle.startsWith(q) && !bTitle.startsWith(q)) return -1;
    if (bTitle.startsWith(q) && !aTitle.startsWith(q)) return 1;
    return 0;
  });
}

// =============================
// 🌸 CATEGORY PAGE REDIRECTS
// =============================
const categoryPages = {
  "rose": "rose.php", "roses": "rose.php",
  "orchid": "orchids.php", "orchids": "orchids.php",
  "tulip": "tulip.php", "tulips": "tulip.php",
  "lily": "lily.php", "lilies": "lily.php",
  "sunflower": "sunflower.php", "sunflowers": "sunflower.php",
  "daisy": "daisies.php", "daisies": "daisies.php",
  "daffodil": "daffodils.php", "daffodils": "daffodils.php",
  "buttercup": "buttercup.php", "buttercups": "buttercup.php",
  "mixed": "mixed_flower.php", "mixed bouquet": "mixed_flower.php",
  "minirose": "minirose.php", "mini rose": "minirose.php", "mini roses": "minirose.php",
  "vip": "vip.php", "vip bouquet": "vip.php",
  "bear": "valentine.php", "bears": "valentine.php",
  "chocolate": "valentine.php", "chocolates": "valentine.php",
  "gift": "occasions.php", "gifts": "occasions.php",
  "jewelry": "occasions.php", "mug": "occasions.php",
  "succulent": "occasions.php", "tea": "occasions.php",
  "basket": "occasions.php", "garden": "occasions.php",
  "gift box": "occasions.php", "romantic box": "occasions.php"
};

// Check if query is a PURE category keyword (not a product name containing a category word)
function isPureCategoryQuery(value) {
  const v = value.toLowerCase().trim();
  const wordCount = v.split(/\s+/).length;

  // Only treat as pure category if 1-2 words AND matches a category key exactly
  if (wordCount > 2) return false;

  const sortedKeys = Object.keys(categoryPages).sort((a, b) => b.length - a.length);

  for (let key of sortedKeys) {
    if (v === key || v === key + "s" || v === key + "es") {
      return true;
    }
  }

  return false;
}

function redirectIfPureCategory(value) {
  if (!isPureCategoryQuery(value)) return false;

  const v = value.toLowerCase().trim();
  const sortedKeys = Object.keys(categoryPages).sort((a, b) => b.length - a.length);

  for (let key of sortedKeys) {
    if (v === key || v === key + "s" || v === key + "es" || v === key.replace(/s$/, "")) {
      window.location.href = categoryPages[key];
      return true;
    }
  }

  return false;
}

// =============================
// 🌸 MAIN SEARCH PERFORM FUNCTION
// =============================
function performSearch(rawValue) {
  if (!rawValue || !rawValue.trim()) {
    debugLog('Empty search value');
    return;
  }

  saveSearchHistory(rawValue);
  const value = rawValue.toLowerCase();
  
  debugLog('Performing search for:', rawValue);

  // STEP 1: Check if it's a pure category query (e.g., "roses", "bears", "chocolates")
  // Only redirect to category page for SHORT exact category matches
  if (isPureCategoryQuery(rawValue)) {
    debugLog('Pure category query detected');
    if (redirectIfPureCategory(rawValue)) return;
  }

  // STEP 2: Try to find a SPECIFIC product match first
  // This ensures "Soft Classic Teddy Bear" goes to the product page, not valentine.php
  const match = findBestMatch(rawValue);
  
  if (match && !match.isCategory) {
    debugLog('Product match found:', match.title);
    window.location.href = match.link;
    return;
  }

  // STEP 3: If no specific product found, check for category match
  if (match && match.isCategory) {
    debugLog('Category match found:', match.category);
    const catKey = match.category.toLowerCase();
    for (let key in categoryPages) {
      if (catKey === key || catKey.includes(key)) {
        window.location.href = categoryPages[key];
        return;
      }
    }
  }

  // STEP 4: FALLBACK → SEARCH RESULTS PAGE
  debugLog('No direct match - redirecting to search results page');
  window.location.href = `search.php?q=${encodeURIComponent(rawValue)}`;
}

// =============================
// 🌸 ENTER KEY NAVIGATION
// =============================
if (searchInput) {
  searchInput.addEventListener('keypress', function (e) {
    if (e.key !== 'Enter') return;
    e.preventDefault();

    const rawValue = this.value.trim();
    performSearch(rawValue);
  });
}

// =============================
// 🌸 SEARCH BUTTON CLICK (MERGED FROM search1.js)
// =============================
if (searchButton) {
  searchButton.addEventListener('click', function () {
    const rawValue = searchInput ? searchInput.value.trim() : '';
    debugLog('Search button clicked with value:', rawValue);
    performSearch(rawValue);
  });
}

// =============================
// 🌸 LIVE FILTER (CURRENT PAGE ONLY)
// =============================
function filterCurrentPage(searchTerm) {
  const products = document.querySelectorAll('.product__item');
  const value = searchTerm.toLowerCase().trim();

  products.forEach(product => {
    const title = product.querySelector('.product__title')?.textContent.toLowerCase() || "";
    const category = product.querySelector('.product__category')?.textContent.toLowerCase() || "";
    const subtitle = product.querySelector('.product__subtitle')?.textContent.toLowerCase() || "";

    product.style.display = (title.includes(value) || category.includes(value) || subtitle.includes(value)) ? "" : "none";
  });
}

if (searchInput && !isSearchPage) {
  searchInput.addEventListener('keyup', function () {
    filterCurrentPage(this.value);
  });
}

// =============================
// 🌸 SEARCH RESULTS PAGE RENDER
// =============================
if (isSearchPage) {
  const params = new URLSearchParams(window.location.search);
  const rawQuery = params.get("q") || "";
  const query = rawQuery.toLowerCase();

  const resultsContainer = document.getElementById("search-results");
  const titleEl = document.getElementById("search-title");
  const noResults = document.getElementById("no-results");

  if (!resultsContainer) {
    debugLog('Results container not found');
  } else {
    if (titleEl) titleEl.textContent = `Results for "${rawQuery}"`;

    // Use findAllMatches for better results
    const filtered = findAllMatches(rawQuery);
    
    debugLog('Search results found:', filtered.length);

    if (filtered.length === 0) {
      if (noResults) noResults.style.display = "block";
    } else {
      filtered.forEach(p => {
        resultsContainer.innerHTML += `
          <div class="product__item">
            <div class="product__banner">
              <a href="${p.link}" class="product__images">
                <img src="${p.image}" class="product__img default" alt="${p.title}" />
              </a>
            </div>
            <div class="product__content">
              <span class="product__category">${p.category}</span>
              <a href="${p.link}"><h3 class="product__title">${p.title}</h3></a>
              ${p.kurdishTitle ? `<p class="product__subtitle">${p.kurdishTitle}</p>` : ""}
              <div class="product__price flex"><span class="new__price">${p.price}</span></div>
            </div>
          </div>
        `;
      });
    }

    // Populate Personalized History Section
    const personalizedSection = document.getElementById("personalized-history");
    const historyGrid = document.getElementById("recent-searches-grid");
    
    if (personalizedSection && historyGrid) {
      fetchSearchHistoryFromServer().then(history => {
        if (history && history.length > 0) {
          personalizedSection.style.display = "block";
          historyGrid.innerHTML = history.slice(0, 4).map(item => {
            const img = getHistoryImage(item);
            return `
              <div class="history-card" onclick="window.location.href='search.php?q=${encodeURIComponent(item)}'">
                ${img ? `<img src="${img}" class="history-card__img" alt="${item}">` : `<div class="history-card__placeholder">🔍</div>`}
                <div class="history-card__content">
                  <h4 class="history-card__title">${item}</h4>
                  <span class="history-card__link">Search Again</span>
                </div>
              </div>
            `;
          }).join('');
        }
      });
    }
  }
}

// =============================
// 🌸 SEARCH HISTORY
// =============================
function getLocalSearchHistory() {
  return JSON.parse(localStorage.getItem("lioraSearchHistory")) || [];
}

function setLocalSearchHistory(history) {
  localStorage.setItem("lioraSearchHistory", JSON.stringify(history));
}

async function fetchSearchHistoryFromServer() {
  if (cachedSearchHistory) {
    return cachedSearchHistory;
  }

  try {
    const response = await fetch('search_history.php?action=fetch', {
      method: 'GET',
      credentials: 'same-origin'
    });

    if (!response.ok) {
      debugLog('Failed to fetch user history');
      return [];
    }

    const data = await response.json();
    if (data && Array.isArray(data.history)) {
      cachedSearchHistory = data.history;
      return data.history;
    }
  } catch (error) {
    debugLog('Error fetching user history:', error);
  }

  return [];
}

async function saveSearchHistory(query) {
  if (!query) return;

  if (getIsLoggedIn()) {
    try {
      const payload = new URLSearchParams();
      payload.append('action', 'save');
      payload.append('query', query.trim());

      const response = await fetch('search_history.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: payload,
        keepalive: true
      });

      if (response.ok) {
        const data = await response.json();
        if (data && Array.isArray(data.history)) {
          cachedSearchHistory = data.history;
          await refreshAllSearchUI();
        } else {
          cachedSearchHistory = null;
        }
      }
    } catch (error) {
      debugLog('Error saving user search history:', error);
    }
    return;
  }

  let history = getLocalSearchHistory();
  history = history.filter(item => item.toLowerCase() !== query.toLowerCase());
  history.unshift(query);
  history = history.slice(0, 6);
  setLocalSearchHistory(history);
  debugLog('Search history saved:', query);
}

function getHistoryImage(query) {
  const q = query.toLowerCase().trim();

  // Try exact match first
  let match = masterCatalog.find(p => p.title.toLowerCase() === q || (p.kurdishTitle && p.kurdishTitle.toLowerCase() === q));
  if (match) return match.image;

  // Try title includes query
  match = masterCatalog.find(p => p.title.toLowerCase().includes(q) || (p.kurdishTitle && p.kurdishTitle.toLowerCase().includes(q)));
  if (match) return match.image;

  // Try query includes title
  match = masterCatalog.find(p => q.includes(p.title.toLowerCase()) || (p.kurdishTitle && q.includes(p.kurdishTitle.toLowerCase())));
  if (match) return match.image;

  // Try category match
  match = masterCatalog.find(p =>
    p.category.toLowerCase() === q || p.category.toLowerCase().includes(q)
  );
  if (match) return match.image;

  // Try word-by-word matching
  const qWords = q.split(/\s+/).filter(Boolean);
  if (qWords.length > 0) {
    match = masterCatalog.find(p => {
      const titleWords = p.title.toLowerCase().split(/\s+/);
      return qWords.some(w => titleWords.some(tw => tw.includes(w) || w.includes(tw)));
    });
    if (match) return match.image;
  }

  return null;
}

async function removeSearchHistory(query) {
  if (getIsLoggedIn()) {
    try {
      const payload = new URLSearchParams();
      payload.append('action', 'remove');
      payload.append('query', query.trim());

      const response = await fetch('search_history.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: payload
      });

      if (!response.ok) {
        debugLog('Failed to remove search history item');
      }
    } catch (error) {
      debugLog('Error removing search history item:', error);
    }
  } else {
    let history = getLocalSearchHistory();
    history = history.filter(item => item.toLowerCase() !== query.toLowerCase());
    setLocalSearchHistory(history);
    debugLog('Search history item removed:', query);
  }

  await refreshAllSearchUI();
}
window.removeSearchHistory = removeSearchHistory;

async function clearAllSearchHistory() {
  if (getIsLoggedIn()) {
    try {
      const payload = new URLSearchParams();
      payload.append('action', 'clear_all');
      const response = await fetch('search_history.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: payload
      });
      const data = await response.json();
      if (!data.success) {
        debugLog('Failed to clear search history:', data.message);
      }
    } catch (error) {
      debugLog('Error clearing all search history:', error);
    }
  } else {
    setLocalSearchHistory([]);
  }

  await refreshAllSearchUI();
}
window.clearAllSearchHistory = clearAllSearchHistory;

const searchPageClearHistoryBtn = document.getElementById("search-page-clear-history");
if (searchPageClearHistoryBtn) {
  searchPageClearHistoryBtn.addEventListener("click", async function () {
    if (!confirm("Are you sure you want to clear all search history?")) return;
    searchPageClearHistoryBtn.disabled = true;
    try {
      await clearAllSearchHistory();
    } finally {
      searchPageClearHistoryBtn.disabled = false;
    }
  });
}

async function refreshAllSearchUI() {
  cachedSearchHistory = null;
  
  // 1. Refresh Account Page List if it exists
  if (typeof window.refreshSearchHistory === 'function') {
    await window.refreshSearchHistory();
  }
  
  // 2. Refresh Search Page Personalized History if it exists
  const personalizedSection = document.getElementById("personalized-history");
  const historyGrid = document.getElementById("recent-searches-grid");
  if (personalizedSection && historyGrid) {
    const history = await fetchSearchHistoryFromServer();
    if (history && history.length > 0) {
      personalizedSection.style.display = "block";
      historyGrid.innerHTML = history.slice(0, 4).map(item => {
        const img = getHistoryImage(item);
        return `
          <div class="history-card" onclick="window.location.href='search.php?q=${encodeURIComponent(item)}'">
            ${img ? `<img src="${img}" class="history-card__img" alt="${item}">` : `<div class="history-card__placeholder">🔍</div>`}
            <div class="history-card__content">
              <h4 class="history-card__title">${item}</h4>
              <span class="history-card__link">Search Again</span>
            </div>
          </div>
        `;
      }).join('');
    } else {
      personalizedSection.style.display = "none";
    }
  }

  // 3. Refresh Search Dropdown if it's visible or about to be
  await showSearchHistory();
}

async function showSearchHistory() {
  const dropdown = document.getElementById("search-history");
  if (!dropdown) return;

  let history = [];
  if (getIsLoggedIn()) {
    history = await fetchSearchHistoryFromServer();
  } else {
    history = getLocalSearchHistory();
  }

  if (!Array.isArray(history) || history.length === 0) {
    dropdown.style.display = "none";
    return;
  }

  dropdown.innerHTML = `<div class="history-header">Recent searches</div>`;

  history.slice(0, 6).forEach(item => {
    const img = getHistoryImage(item);
    const imgHTML = img
      ? `<img src="${img}" class="history-thumb" alt="${item}" />`
      : `<div class="history-thumb history-thumb--placeholder">🔍</div>`;

    dropdown.innerHTML += `
      <div class="history-item" data-query="${item.replace(/"/g, '&quot;')}">
        ${imgHTML}
        <span class="history-item__text">${item}</span>
        <button class="history-item__remove" data-remove="${item.replace(/"/g, '&quot;')}" title="Remove">✕</button>
      </div>
    `;
  });

  dropdown.style.display = "block";
}

document.addEventListener("click", function (e) {
  // Remove button clicked
  const removeBtn = e.target.closest(".history-item__remove");
  if (removeBtn) {
    e.stopPropagation();
    removeSearchHistory(removeBtn.dataset.remove);
    return;
  }

  // History item clicked (anywhere except the X)
  const historyItem = e.target.closest(".history-item");
  if (historyItem && historyItem.dataset.query) {
    window.location.href = `search.php?q=${encodeURIComponent(historyItem.dataset.query)}`;
  }
});

if (searchInput) {
  searchInput.addEventListener("focus", showSearchHistory);
}

document.addEventListener("click", function (e) {
  const box = document.getElementById("search-history");
  if (!e.target.closest(".custom-search")) {
    if (box) box.style.display = "none";
  }
});

function showInvalidToast() {
  const toast = document.getElementById("invalid-toast");
  const input = document.querySelector(".search-input");
  if (!toast) return;

  // Shake the input
  input?.classList.add("invalid");
  setTimeout(() => input?.classList.remove("invalid"), 600);

  // Show toast
  toast.classList.remove("hide");
  toast.classList.add("show");

  // Hide after 2.8s
  setTimeout(() => {
    toast.classList.add("hide");
    setTimeout(() => toast.classList.remove("show", "hide"), 300);
  }, 2800);
}
