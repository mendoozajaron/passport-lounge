<script setup lang="ts">
interface AboutItem {
  eyebrow: string
  title: string
  description: string
  image: string
  href?: string
}

interface Highlight {
  title: string
  image: string
}

const highlights: Highlight[] = [
  { title: 'Inclusive and Unapologetic', image: '/images/ab1.jpg' },
  { title: 'Your Passport to the World', image: '/images/ab2.jpg' },
  { title: 'First Class, No Attitude', image: '/images/ab3.jpg' },
  { title: 'Safety Meets Celebration', image: '/images/ab4.jpg' },
  { title: 'Local Roots, Global Spin', image: '/images/ab5.jpg' },
]

const items: AboutItem[] = [
  {
    eyebrow: 'One World, one lounge',
    title: 'A place to be yourself',
    description:
      'Passport Lounge was born from a singular vision: you don’t have to leave Manila to experience the world. Grounded in the pulse of Makati, we bring global flavors, soundscapes, and nightlife traditions together under one roof creating a vibrant, international sanctuary that feels both far away and delightfully close to home.',
    image: '/images/about-bar.jpg',
    href: '/about',
  },
  {
    eyebrow: 'One World, one lounge',
    title: "There's a seat for you",
    description:
      'Whether you’re a regular on the scene or walking into your first gay bar, there’s a seat for you. Destination: Makati. Welcome aboard.',
    image: '/images/about-crowd.jpg',
    href: '/menu',
  },
]
</script>

<template>
  <section
  id="about"
  class="relative bg-cover bg-center bg-no-repeat"
  style="background-image: url('/images/ab-bg2.jpg')"
>
  <div class="absolute inset-0 bg-black/60" aria-hidden="true"></div>

  <div class="relative mx-auto flex w-full max-w-6xl flex-col gap-8 px-4 py-16">
    <h2 class="text-center text-4xl font-bold text-white">One World, One Lounge</h2>

    <ul class="mb-8 flex flex-wrap justify-center gap-x-10 gap-y-8">
      <li
        v-for="h in highlights"
        :key="h.title"
        class="group flex w-32 flex-col items-center text-center md:w-44"
      >
        <div
          class="h-32 w-32 overflow-hidden rounded-full shadow-lg md:h-44 md:w-44"
        >
          <img
            :src="h.image"
            :alt="h.title"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
            loading="lazy"
          />
        </div>
        <p class="mt-4 text-sm font-semibold leading-snug text-white md:text-base">
          {{ h.title }}
        </p>
      </li>
    </ul>

    <article
      v-for="(item, index) in items"
      :key="item.title"
      class="flex flex-col overflow-hidden rounded-3xl bg-muted md:min-h-[340px] md:flex-row"
      :class="{ 'md:flex-row-reverse': index % 2 === 1 }"
    >
      <div class="h-64 md:h-auto md:w-1/2">
        <img
          :src="item.image"
          :alt="item.title"
          class="h-full w-full object-cover"
          loading="lazy"
        />
      </div>

      <div class="flex flex-col justify-center gap-4 p-8 md:w-1/2 md:p-10">
        <p class="text-sm uppercase tracking-wide text-muted-foreground">
          {{ item.eyebrow }}
        </p>
        <h3 class="text-2xl font-semibold text-white">
          {{ item.title }}
        </h3>
        <p class="leading-relaxed text-muted-foreground">
          {{ item.description }}
        </p>

        <a
          v-if="item.href"
          :href="item.href"
          target="_blank"
          rel="noopener noreferrer"
          class="mt-2 inline-flex w-fit items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-medium text-primary-foreground transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
        >
          Read more
          <span aria-hidden="true">→</span>
        </a>
      </div>
    </article>
  </div>
</section>
</template>
