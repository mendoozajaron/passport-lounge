<script setup>
import { ref, onMounted } from 'vue';
import QuizModal from './components/QuizModal.vue';
import ContactSection from './components/ContactSection.vue';
import GallerySection from './components/GallerySection.vue';
import AboutSection from './components/AboutSection.vue';
import CaptainsSection from './components/CaptainsSection.vue';
import Menu from './components/Menu.vue';

const quiz = ref(null);
const menuOpen = ref(false);
const showTab = ref(true);

// Which page are we on? (Laravel serves this same app for each of these URLs)
const path = window.location.pathname.replace(/\/+$/, '');
const isAboutPage = path === '/about';
const isMenuPage = path === '/menu';

if (isAboutPage) document.title = 'The World, One Lounge | Passport Lounge Manila';
if (isMenuPage) document.title = 'Menu | Passport Lounge Manila';

// Placeholder copy for the "What to expect" cards. Edit freely.
const values = [
  { title: 'Great cocktails', text: 'Classic favorites and creative pours, made by bartenders who love what they do.' },
  { title: 'Friendly faces', text: 'A crowd and a team that make you feel at home the moment you walk in.' },
  { title: 'Come as you are', text: 'Regular or first-timer, there is a seat for you and a night worth having.' },
];

const photos = ref([]);

const hues = [275, 305, 330, 205, 255, 185, 15];
const tiles = Array.from({ length: 30 }, (_, i) => {
  const h = hues[(i * 3) % hues.length];
  return { '--g': `linear-gradient(135deg, hsl(${h} 70% 38%), hsl(${h + 35} 80% 18%))` };
});

// Fallback shown until the database content loads (or if the request fails).
const about = ref({
  title: 'The World, One Lounge',
  body:
    'Passport Lounge Manila is a bar for people who love a good night out and a place where they can be themselves. Think great cocktails, friendly bartenders, and a crowd that makes you feel at home the moment you arrive.\n\nWhether you’re a regular on the scene or walking into your first gay bar, there’s a seat for you.',
  image_url: '/images/about-bar.jpg',
  button_label: 'Read more',
  button_url: '/about',
  extra: {
    opening: 'Opening soon',
    where: 'Manila, Philippines (address to be announced)',
    hours: 'Hours to be announced',
    social: '@passportloungemanila',
  },
});

async function loadAbout() {
  try {
    const res = await fetch('/api/sections/about');
    if (!res.ok) return;
    const data = await res.json();
    about.value = {
      ...about.value,
      ...data,
      image_url: data.image_url || about.value.image_url,
      extra: { ...about.value.extra, ...(data.extra || {}) },
    };
  } catch (e) {
    // keep the fallback
  }
}

async function loadGallery() {
  try {
    const res = await fetch('/api/gallery');
    if (!res.ok) return;
    const data = await res.json();
    if (data.length) photos.value = data.map((p) => p.url);
  } catch (e) {
    // keep the fallback photos
  }
}

onMounted(() => {
  // The menu page loads its own data, so skip these there.
  if (isMenuPage) return;
  loadAbout();
  loadGallery();
});
</script>

<template>
  <nav class="nav" aria-label="Main">
    <a class="brand" href="/#home"><small>THE</small>PASSPORT LOUNGE Manila</a>

    <div class="links" :class="{ open: menuOpen }">
      <a href="/#home" @click="menuOpen = false">Home</a>
      <a :href="isAboutPage ? '/about' : '/#about'" @click="menuOpen = false">OUR STORY</a>
      <a href="/menu" @click="menuOpen = false">MENU</a>
      <a href="/#gallery" @click="menuOpen = false">THE LOUNGE</a>
      <a href="/#contact" @click="menuOpen = false">SAY HELLO</a>
      <button class="cta mobile-only" @click="quiz.show(); menuOpen = false">WHERE SHOULD THE PASSPORT TAKE YOU?</button>
    </div>

    <button class="cta desktop-only" @click="quiz.show()">WHERE SHOULD THE PASSPORT TAKE YOU?</button>
    <button class="menu-toggle" :aria-expanded="menuOpen" aria-label="Menu" @click="menuOpen = !menuOpen">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <!-- ABOUT PAGE (shown at /about) -->
  <main v-if="isAboutPage" class="about-page">
    <section class="section about about-with-image">
      <div class="about-main">
        <div class="about-text">
          <h1>{{ about.title }}</h1>
          <p style="white-space: pre-line">{{ about.body }}</p>
          <!-- <div class="hero-actions">
            <button class="btn" @click="quiz.show()">Find your drink</button>
            <a class="btn outline" href="/#contact">Say hello</a>
          </div> -->
        </div>

        <!-- <div class="about-image">
          <img v-if="about.image_url" :src="about.image_url" :alt="about.title" />
        </div> -->
      </div>

      <!-- <ul class="facts">
        <li><b>Status</b>{{ about.extra.opening }}</li>
        <li><b>Where</b>{{ about.extra.where }}</li>
        <li><b>Hours</b>{{ about.extra.hours }}</li>
        <li><b>Follow us</b>{{ about.extra.social }}</li>
      </ul> -->
    </section>

    <!-- <section class="section values">
      <h2>What to expect</h2>
      <div class="value-grid">
        <article v-for="v in values" :key="v.title" class="value-card">
          <h3>{{ v.title }}</h3>
          <p>{{ v.text }}</p>
        </article>
      </div>
    </section> -->
    <CaptainsSection />
  </main>

  <!-- MENU PAGE (shown at /menu) -->
  <main v-else-if="isMenuPage">
    <Menu />
  </main>

  <!-- HOME PAGE (shown at /) -->
  <main v-else>
    <section id="home" class="section hero">
      <div class="collage" aria-hidden="true"><i v-for="(t, i) in tiles" :key="i" :style="t"></i></div>
      <div class="hero-content">
        <img :src="'/images/hl.jpg'" alt="Passport Lounge Manila" class="hero-stamp-img" @error="$event.target.style.display = 'none'">
        <h1>Come as you are.</h1>
        <h1 class="inline-block mb-4">Go Anywhereeeee.</h1>
        <p>A new kind of nightlife in Manila that's open to everyone, inspired by anywhere.</p>
        <div class="hero-actions">
          <button class="btn" @click="quiz.show()">Find your drink</button>
          <a class="btn outline" href="#about">About us</a>
        </div>
      </div>
    </section>

    <AboutSection />
    <section
      id="gallery"
      class="section quiz-wrap lounge"
      style="background-image: url('/images/lightballs.jpg');"
    >
      <!-- <h2 class="lounge-title">THE LOUNGE</h2> -->
      <GallerySection :photos="photos" />
    </section>

    <section id="contact" class="section about">
      <div>
        <h2>Contact us</h2>
        <p>Leave your details and we'll reach out with news about our opening.</p>
      </div>
      <ContactSection />
    </section>
  </main>

  <!-- SHARED BY ALL PAGES -->
  <aside class="rail" aria-label="Social links">
    <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M13.5 21v-8h2.7l.4-3.2h-3.1V7.8c0-.9.3-1.5 1.6-1.5h1.7V3.4c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.5-4 4.1v2.4H7.700V13h2.700v8h3.100z"/></svg></a>
    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24"><rect x="3.500" y="3.500" width="17" height="17" rx="5" fill="none" stroke="#fff" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="#fff" stroke-width="2"/><circle cx="17.200" cy="6.800" r="1.200"/></svg></a>
    <a href="#" aria-label="Email"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2" fill="none" stroke="#fff" stroke-width="2"/><path d="M4 7l8 6 8-6" fill="none" stroke="#fff" stroke-width="2"/></svg></a>
  </aside>

  <div v-if="showTab" class="tab">
    <button class="tab-go" @click="quiz.show()">WHERE SHOULD THE PASSPORT TAKE YOU?</button>
    <button class="tab-x" aria-label="Dismiss" @click="showTab = false">&times;</button>
  </div>

  <QuizModal ref="quiz" />

  <footer> Passport Lounge Manila. Please drink responsibly.</footer>
</template>