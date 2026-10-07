<script setup>
const captains = [
  {
    name: 'Xavier',
    image: '/images/xav.jpg',
    bio: [
      'Born in the United States to Filipino parents, Xavier Joven built a distinguished 15+ year career across Los Angeles, the U.S., and the UK, advising founders and executives across global advertising agencies, entertainment, media, and tech brands. As a people and culture leader, he developed a sharp perspective on how brand, talent, and experience intersect to create meaningful connections.',
      'Now bringing that global vision home to Manila, Xavier co-founded Passport Lounge in Makati. For him, Passport is both a personal return to his heritage and an ambitious addition to the city’s evolving nightlife scene. A sophisticated, welcoming haven blending world-class cocktails, food, music, and entertainment. Inspired by global queer culture and travel, Xavier aims to anchor a venue that feels effortlessly international yet distinctly Manila.',
    ],
  },
  {
    name: 'Justin',
    image: '/images/just.jpg',
    bio: [
      'Justin Henry’s hospitality journey spans some of America’s most iconic markets, from Orlando and New Orleans to Los Angeles and West Hollywood, including a tenure as Hotel Manager at Hollywood’s legendary Chateau Marmont. For Justin, however, world-class service has always been secondary to something deeper: creating spaces where people feel truly seen, valued, and free to be themselves.',
      'Raised by a deaf mother, Justin learned early on the vital importance of radical inclusion and accessibility. During his time with Hyatt, he established and led a global LGBTQ+ employee network, directing initiatives that supported HIV/AIDS awareness, at-risk youth, and unhoused community members. At Passport Lounge, Justin brings this deep-rooted commitment to Makati, shaping a safe, vibrant sanctuary where locals, travelers, queer and trans individuals, and allies can connect, celebrate, and belong.',
    ],
  },
]

const together = {
  image: '/images/gc.jpg',
  alt: 'Xavier and Justin, co-founders of Passport Lounge Manila',
  paragraphs: [
    'Co-founded by Xavier and Justin, Passport weaves global travel energy with a steadfast commitment to community. Inspired by iconic queer capitals across the globe, it was built on a simple promise: a space where you never have to choose between feeling safe and having an extraordinary night out.',
    'We aren’t just another nightlife spot, we are your departure point. Expect elevated cocktails, rich culinary bites, and first-class service with zero first-class attitude.',
    'Locals, travelers, queer icons, and allies alike: come exactly as you are.',
  ],
  closing: 'Welcome aboard!',
}
</script>

<template>
  <section class="section captains">
    <h2 class="captains-title">The Captains</h2>

    <div class="captains-grid">
      <article v-for="c in captains" :key="c.name" class="captain">
        <div class="captain-photo">
          <img :src="c.image" :alt="c.name" loading="lazy" />
        </div>
        <h3>{{ c.name }}</h3>
        <p v-for="(para, i) in c.bio" :key="i">{{ para }}</p>
      </article>
    </div>

    <figure class="captains-together">
      <div class="together-photo">
        <img :src="together.image" :alt="together.alt" loading="lazy" />
      </div>
      <figcaption>
        <p v-for="(para, i) in together.paragraphs" :key="i">{{ para }}</p>
        <p class="welcome">{{ together.closing }}</p>
      </figcaption>
    </figure>
  </section>
</template>

<style scoped>
.captains {
  max-width: 1100px;
  margin: 0 auto;
  padding: 4rem 1rem;
}

.captains-title {
  text-align: center;
  margin-bottom: 2.5rem;
}

.captains-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2.5rem;
}

.captain {
  background: rgba(255, 255, 255, 0.06);
  border-radius: 1.5rem;
  padding: 1.5rem;
}

.captain-photo {
  aspect-ratio: 4 / 5;
  overflow: hidden;
  border-radius: 1rem;
  margin-bottom: 1.25rem;
}

.captain-photo img,
.together-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.captain h3 {
  font-size: 1.6rem;
  margin: 0 0 0.75rem;
}

.captain p,
.captains-together p {
  line-height: 1.7;
  margin: 0 0 1rem;
}

.captains-together {
  margin: 3rem 0 0;
  text-align: center;
}

.together-photo {
  aspect-ratio: 16 / 9;
  overflow: hidden;
  border-radius: 1.5rem;
  margin-bottom: 1.75rem;
}

.captains-together figcaption {
  max-width: 760px;
  margin: 0 auto;
}

.welcome {
  font-size: 1.4rem;
  font-weight: 700;
}

@media (max-width: 768px) {
  .captains-grid {
    grid-template-columns: 1fr;
  }
}
</style>