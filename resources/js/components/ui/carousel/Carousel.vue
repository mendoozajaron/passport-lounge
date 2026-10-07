<script setup>
import { provide, ref, watchEffect } from 'vue';
import emblaCarouselVue from 'embla-carousel-vue';
import { cn } from '@/lib/utils';
import { CAROUSEL_INJECTION_KEY } from './useCarousel';

const props = defineProps({
  opts: { type: Object, default: () => ({}) },
  plugins: { type: Array, default: () => [] },
  orientation: { type: String, default: 'horizontal' },
  class: { type: String, default: '' },
});
const emit = defineEmits(['init-api']);

const [emblaRef, emblaApi] = emblaCarouselVue(
  { ...props.opts, axis: props.orientation === 'horizontal' ? 'x' : 'y' },
  props.plugins,
);

const canScrollPrev = ref(false);
const canScrollNext = ref(false);

function onSelect(api) {
  if (!api) return;
  canScrollPrev.value = api.canScrollPrev();
  canScrollNext.value = api.canScrollNext();
}
function scrollPrev() { emblaApi.value?.scrollPrev(); }
function scrollNext() { emblaApi.value?.scrollNext(); }
function onKeydown(e) {
  if (e.key === 'ArrowLeft') { e.preventDefault(); scrollPrev(); }
  else if (e.key === 'ArrowRight') { e.preventDefault(); scrollNext(); }
}

watchEffect((onCleanup) => {
  const api = emblaApi.value;
  if (!api) return;
  onSelect(api);
  const handler = () => onSelect(api);
  api.on('select', handler);
  api.on('reInit', handler);
  emit('init-api', api);
  onCleanup(() => api.off('select', handler));
});

provide(CAROUSEL_INJECTION_KEY, {
  carouselRef: emblaRef, api: emblaApi, opts: props.opts, orientation: props.orientation,
  scrollPrev, scrollNext, canScrollPrev, canScrollNext,
});

defineExpose({ scrollPrev, scrollNext, canScrollPrev, canScrollNext });
</script>

<template>
  <div :class="cn('relative', props.class)" role="region" aria-roledescription="carousel" tabindex="0" @keydown="onKeydown">
    <slot />
  </div>
</template>
