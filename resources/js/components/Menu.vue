<script setup>
import { ref, computed, watch, onMounted } from 'vue'

const props = defineProps({
  endpoint: { type: String, default: '/api/menu' },
  heroImage: { type: String, default: '/images/lounge.jpg' },
  images: { type: Array, default: () => [] },
})

const raw = ref([])
const loading = ref(true)
const failed = ref(false)
const activeGroup = ref('')
const activeCategory = ref('')

/* ---------------------------------------------------------------
   ADAPTER: maps the menu_items table to what the page needs.
   DB columns: name, category ('drink' | 'food'), price,
   description, position. Optional (if you add them later):
   section (sidebar group), image_url.
---------------------------------------------------------------- */
const GROUP_LABELS = { drink: 'Drinks', food: 'Food' }

const toItem = (i) => ({
  id: i.id,
  group: GROUP_LABELS[i.category] ?? i.category,
  category: i.section || 'All',
  name: i.name,
  description: i.description ?? '',
  price: i.price,
  image: i.image_url ?? '',
  sort: i.position ?? 0,
  available: !(i.is_available === false || i.is_available === 0),
})

onMounted(async () => {
  try {
    const res = await fetch(props.endpoint, { headers: { Accept: 'application/json' } })
    if (!res.ok) throw new Error(res.status)
    const data = await res.json()
    raw.value = (Array.isArray(data) ? data : Object.values(data).flat())
      .map(toItem)
      .filter((i) => i.available)
  } catch (e) {
    failed.value = true
  } finally {
    loading.value = false
  }
})

const unique = (arr) => [...new Set(arr)]

const groups = computed(() => unique(raw.value.map((i) => i.group)))
const categories = computed(() =>
  unique(raw.value.filter((i) => i.group === activeGroup.value).map((i) => i.category))
)
const items = computed(() =>
  raw.value
    .filter((i) => i.group === activeGroup.value && i.category === activeCategory.value)
    .sort((a, b) => a.sort - b.sort)
)
const strip = computed(() => {
  if (props.images.length) return props.images
  return raw.value.filter((i) => i.group === activeGroup.value && i.image).slice(0, 8).map((i) => i.image)
})

watch(groups, (g) => { if (!activeGroup.value && g.length) activeGroup.value = g[0] }, { immediate: true })
watch(categories, (c) => { if (!c.includes(activeCategory.value)) activeCategory.value = c[0] ?? '' }, { immediate: true })

const peso = (n) =>
  '₱' + Number(n).toLocaleString('en-PH', { minimumFractionDigits: 0, maximumFractionDigits: 2 })

const heroStyle = computed(() =>
  props.heroImage ? { backgroundImage: `linear-gradient(rgba(8,8,10,.65), rgba(8,8,10,.9)), url(${props.heroImage})` } : {}
)
</script>

<template>
  <main class="menu-page">
    <header class="hero" :style="heroStyle">
      <p class="eyebrow">Passport Lounge Manila</p>
      <h1>Menu</h1>
      <span class="rule" aria-hidden="true"></span>
    </header>

    <div class="wrap">
      <p v-if="loading" class="state">Loading the menu…</p>
      <p v-else-if="failed" class="state">We couldn't load the menu. Please refresh the page.</p>
      <p v-else-if="!raw.length" class="state">The menu is coming soon.</p>

      <template v-else>
        <!-- Top-level tabs -->
        <div class="tabs" role="tablist" aria-label="Menu type">
          <button
            v-for="g in groups"
            :key="g"
            role="tab"
            :aria-selected="g === activeGroup"
            :class="{ active: g === activeGroup }"
            @click="activeGroup = g"
          >{{ g }}</button>
        </div>

        <!-- Image strip -->
        <div v-if="strip.length" class="strip" tabindex="0" aria-label="Menu photos">
          <img v-for="(src, i) in strip" :key="i" :src="src" alt="" loading="lazy" />
        </div>

        <div class="body" :class="{ single: categories.length <= 1 }">
          <!-- Category sidebar (only when there are 2+ categories) -->
          <nav v-if="categories.length > 1" class="cats" aria-label="Categories">
            <button
              v-for="c in categories"
              :key="c"
              :class="{ active: c === activeCategory }"
              :aria-current="c === activeCategory ? 'true' : undefined"
              @click="activeCategory = c"
            >{{ c }}</button>
          </nav>

          <!-- Items -->
          <section class="list" :aria-label="activeCategory">
            <template v-if="categories.length > 1">
              <h2>{{ activeCategory }}</h2>
              <span class="rule sm" aria-hidden="true"></span>
            </template>

            <ul>
              <li v-for="item in items" :key="item.id">
                <div class="info">
                  <h3>{{ item.name }}</h3>
                  <p v-if="item.description">{{ item.description }}</p>
                </div>
                <span class="price">{{ peso(item.price) }}</span>
              </li>
            </ul>
          </section>
        </div>
      </template>
    </div>
  </main>
</template>

<style scoped>
.menu-page {
  --bg: #0d0d0f;
  --text: #e8ecf5;
  --muted: rgba(232, 236, 245, 0.6);
  --gold: #d4a86a;
  --line: rgba(255, 255, 255, 0.09);
  --font-display: 'Bricolage Grotesque', system-ui, sans-serif; /* swap to 'Playfair Display' italic for the Abbey look */
  --font-body: 'DM Sans', system-ui, sans-serif;

  background: var(--bg);
  color: var(--text);
  font-family: var(--font-body);
  min-height: 100vh;
}

/* Hero */
.hero {
  display: grid;
  justify-items: center;
  gap: 0.75rem;
  padding: 9rem 1.5rem 4.5rem;
  text-align: center;
  background: radial-gradient(ellipse at 50% 0%, #2a1520 0%, var(--bg) 70%) center / cover;
}
.eyebrow {
  margin: 0;
  color: var(--gold);
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.3em;
  text-transform: uppercase;
}
.hero h1 {
  margin: 0;
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(3rem, 10vw, 6rem);
  letter-spacing: -0.03em;
  line-height: 1;
}
.rule { width: 60px; height: 1px; background: var(--gold); }
.rule.sm { display: block; width: 40px; margin: 0.75rem 0 1.5rem; }

.wrap { max-width: 1240px; margin: 0 auto; padding: 0 1.5rem 5rem; }
.state { text-align: center; color: var(--muted); padding: 4rem 0; }

/* Tabs */
.tabs { display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 2.5rem 0 2rem; }
.tabs button {
  padding: 0.8rem 1.5rem;
  background: transparent;
  border: 0;
  border-radius: 2px;
  color: var(--muted);
  font: 700 0.75rem var(--font-body);
  letter-spacing: 0.2em;
  text-transform: uppercase;
  cursor: pointer;
  transition: color 0.2s, background 0.2s;
}
.tabs button:hover { color: var(--text); }
.tabs button.active { background: var(--gold); color: #1a1208; }

/* Image strip */
.strip {
  display: flex;
  gap: 1rem;
  overflow-x: auto;
  scroll-snap-type: x proximity;
  padding-bottom: 0.5rem;
  scrollbar-width: none;
}
.strip::-webkit-scrollbar { display: none; }
.strip img {
  flex: 0 0 auto;
  width: min(348px, 78vw);
  height: 268px;
  object-fit: cover;
  border-radius: 8px;
  scroll-snap-align: start;
}

/* Body */
.body { display: grid; grid-template-columns: 240px 1fr; gap: 3rem; margin-top: 3rem; }
.body.single { grid-template-columns: 1fr; max-width: 820px; }

.cats { position: sticky; top: 2rem; align-self: start; display: grid; gap: 0.25rem; }
.cats button {
  text-align: left;
  padding: 0.9rem 0.75rem;
  background: transparent;
  border: 0;
  border-left: 2px solid transparent;
  color: var(--muted);
  font: 600 0.78rem var(--font-body);
  letter-spacing: 0.18em;
  text-transform: uppercase;
  cursor: pointer;
  transition: color 0.2s, border-color 0.2s;
}
.cats button:hover { color: var(--text); }
.cats button.active { color: var(--gold); border-left-color: var(--gold); }

.list h2 {
  margin: 0;
  font-family: var(--font-display);
  font-weight: 800;
  font-size: clamp(1.8rem, 4vw, 2.6rem);
  letter-spacing: -0.02em;
}
.list ul { list-style: none; margin: 0; padding: 0; }
.list li {
  display: flex;
  justify-content: space-between;
  gap: 1.5rem;
  padding: 1.4rem 0.5rem;
  border-bottom: 1px solid var(--line);
}
.info { max-width: 62ch; }
.info h3 { margin: 0; font-size: 1rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
.info p { margin: 0.4rem 0 0; color: var(--muted); font-size: 0.9rem; line-height: 1.55; }
.price { color: var(--gold); font-family: var(--font-display); font-weight: 700; white-space: nowrap; }

/* Focus + motion */
button:focus-visible, .strip:focus-visible { outline: 2px solid var(--gold); outline-offset: 2px; }
@media (prefers-reduced-motion: reduce) { * { transition: none !important; } }

/* Mobile: sidebar becomes a scrolling chip row */
@media (max-width: 800px) {
  .hero { padding-top: 7rem; }
  .strip img { height: 200px; }
  .body { grid-template-columns: 1fr; gap: 1.5rem; margin-top: 2rem; }
  .cats {
    position: static;
    display: flex;
    overflow-x: auto;
    gap: 0.25rem;
    border-bottom: 1px solid var(--line);
    scrollbar-width: none;
  }
  .cats button {
    flex: 0 0 auto;
    border-left: 0;
    border-bottom: 2px solid transparent;
    padding: 0.8rem 0.9rem;
  }
  .cats button.active { border-bottom-color: var(--gold); }
}
</style>