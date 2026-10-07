import { inject } from 'vue';

export const CAROUSEL_INJECTION_KEY = Symbol('carousel');

export function useCarousel() {
  const carousel = inject(CAROUSEL_INJECTION_KEY);
  if (!carousel) throw new Error('Carousel components must be used within <Carousel>');
  return carousel;
}
