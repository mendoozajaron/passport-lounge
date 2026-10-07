<script setup>
import { ref, watch, onMounted, onUnmounted, nextTick } from 'vue';
import axios from 'axios';
import QuizSection from './QuizSection.vue';

const questions = ref([]);
const open = ref(false);
const playing = ref(false);
const panel = ref(null);

function show() {
  if (!questions.value.length) return;
  playing.value = false;
  open.value = true;
  nextTick(() => panel.value?.focus());
}
function close() { open.value = false; }
function onKey(e) { if (e.key === 'Escape') close(); }

watch(open, (v) => { document.body.style.overflow = v ? 'hidden' : ''; });

onMounted(async () => {
  window.addEventListener('keydown', onKey);
  try { questions.value = (await axios.get('/api/quiz')).data; } catch { /* no quiz, no popup */ }
  show(); // pops up as soon as the site opens
});
onUnmounted(() => window.removeEventListener('keydown', onKey));

defineExpose({ show });
</script>

<template>
  <div v-if="open" class="overlay" @click.self="close">
    <div ref="panel" class="modal quiz-card" role="dialog" aria-modal="true" aria-label="Destination quiz" tabindex="-1">
      <button class="modal-x" aria-label="Close" @click="close">&times;</button>

      <div v-if="!playing">
        <h3>Wanna know where you should be?</h3>
        <p>Answer {{ questions.length }} quick questions and we’ll tell you where you belong.</p>
        <div class="ask-actions">
          <button class="btn" @click="playing = true">Let’s find out</button>
          <button class="btn ghost" @click="close">Maybe later</button>
        </div>
      </div>

      <QuizSection v-else :questions="questions" @close="close" />
    </div>
  </div>
</template>
