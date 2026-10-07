<script setup lang="ts">
import { ref } from 'vue'
import Autoplay from 'embla-carousel-autoplay'
import type { CarouselApi } from '@/components/ui/carousel'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel'

defineProps<{ photos: string[] }>()

const selected = ref(0)

const autoplay = Autoplay({
  delay: 2000,
  stopOnInteraction: false,
  stopOnMouseEnter: true,
})

function onInit(api: CarouselApi) {
  if (!api) return
  selected.value = api.selectedScrollSnap()
  api.on('select', () => (selected.value = api.selectedScrollSnap()))
  api.on('reInit', () => (selected.value = api.selectedScrollSnap()))
}
</script>

<template>
  <Carousel
    class="relative w-full"
    :plugins="[autoplay]"
    :opts="{ align: 'center', loop: true }"
    @init-api="onInit"
  >
   <CarouselContent class="py-16">
  <CarouselItem v-for="(src, index) in photos" :key="index" class="basis-1/3">
    <div
      class="relative p-1 transition-all duration-500 ease-out"
      :class="index === selected
        ? 'z-10 scale-125 opacity-100'
        : 'scale-75 opacity-50'"
    >
      <img :src="src" alt="" class="aspect-square w-full rounded-xl object-cover" />
    </div>
  </CarouselItem>
  </CarouselContent>
    <CarouselPrevious />
    <CarouselNext />
  </Carousel>
</template>