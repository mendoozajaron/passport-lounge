<script setup lang="ts">
import Autoplay from 'embla-carousel-autoplay'

import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from '@/components/ui/carousel'
</script>

<template>
  <Carousel
    class="w-full max-w-xs"
    :plugins="[
      Autoplay({
        delay: 2000,
      }),
    ]"
  >
    <CarouselContent>
      <CarouselItem>
        <div class="p-1">
          Slide 1
        </div>
      </CarouselItem>

      <CarouselItem>
        <div class="p-1">
          Slide 2
        </div>
      </CarouselItem>

      <CarouselItem>
        <div class="p-1">
          Slide 3
        </div>
      </CarouselItem>
    </CarouselContent>

    <CarouselPrevious />
    <CarouselNext />
  </Carousel>
</template>