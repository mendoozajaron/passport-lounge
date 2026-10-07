<script setup>
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { useCarousel } from './useCarousel';

const props = defineProps({ class: { type: String, default: '' } });
const { orientation, scrollPrev, canScrollPrev } = useCarousel();
</script>

<template>
  <Button
    :class="cn('absolute h-8 w-8 rounded-full p-0', orientation === 'horizontal' ? '-left-4 top-1/2 -translate-y-1/2' : '-top-4 left-1/2 -translate-x-1/2 rotate-90', props.class)"
    variant="outline" size="icon" :disabled="!canScrollPrev" @click="scrollPrev"
  >
    <span aria-hidden="true">&larr;</span>
    <span class="sr-only">Previous slide</span>
  </Button>
</template>
