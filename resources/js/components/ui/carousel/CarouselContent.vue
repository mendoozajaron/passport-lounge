<script setup>
import { cn } from '@/lib/utils';
import { useCarousel } from './useCarousel';

const props = defineProps({ class: { type: String, default: '' } });
const { carouselRef, orientation } = useCarousel();
</script>

<template>
  <div ref="carouselRef" class="overflow-hidden">
    <div :class="cn('flex', orientation === 'horizontal' ? '-ml-4' : '-mt-4 flex-col', props.class)">
      <slot />
    </div>
  </div>
</template>
