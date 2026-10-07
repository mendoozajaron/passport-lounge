<script setup>
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { useCarousel } from './useCarousel';

const props = defineProps({ class: { type: String, default: '' } });
const { orientation, scrollNext, canScrollNext } = useCarousel();
</script>

<template>
  <Button
    :class="cn('absolute h-8 w-8 rounded-full p-0', orientation === 'horizontal' ? '-right-4 top-1/2 -translate-y-1/2' : '-bottom-4 left-1/2 -translate-x-1/2 rotate-90', props.class)"
    variant="outline" size="icon" :disabled="!canScrollNext" @click="scrollNext"
  >
    <span aria-hidden="true">&rarr;</span>
    <span class="sr-only">Next slide</span>
  </Button>
</template>
