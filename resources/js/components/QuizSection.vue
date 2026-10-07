<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({ questions: { type: Array, required: true } });
const emit = defineEmits(['close']);

const step = ref(0);
const answers = ref([]);
const awaitingEmail = ref(false);
const result = ref(null);
const failed = ref(false);

const email = ref('');
const emailing = ref(false);
const emailError = ref('');

const current = computed(() => props.questions[step.value]);
const percent = computed(() => (step.value / props.questions.length) * 100);

function pick(optionId) {
  answers.value.push(optionId);
  if (step.value < props.questions.length - 1) { step.value++; return; }
  awaitingEmail.value = true; // last answer picked — ask for the email before revealing the result
}

async function reveal() {
  emailing.value = true; emailError.value = '';
  try {
    result.value = (await axios.post('/api/quiz/email', { answers: answers.value, email: email.value })).data;
  } catch (e) {
    const errs = e.response?.data?.errors;
    emailError.value = errs ? Object.values(errs).flat().join(' ') : 'Could not send that. Try again.';
  } finally { emailing.value = false; }
}

function restart() {
  step.value = 0; answers.value = []; result.value = null; failed.value = false;
  awaitingEmail.value = false; email.value = ''; emailError.value = '';
}
</script>

<template>
  <div v-if="result" class="result">
    <div class="stamp" aria-hidden="true">
      <small>YOUR PLACE IS</small><i></i><strong>{{ result.name }}</strong><i></i><small>{{ result.match }}% MATCH</small>
    </div>
    <h3>You belong in {{ result.name }}</h3>
    <p style="margin-inline:auto">{{ result.tagline }}</p>
    <p class="ok">Sent to {{ email }} too.</p>
    <div class="ask-actions" style="justify-content:center">
      <button class="btn ghost" @click="restart">Take it again</button>
      <button class="btn ghost" @click="emit('close')">Close</button>
    </div>
  </div>

  <div v-else-if="awaitingEmail">
    <h3>Almost there</h3>
    <p>Enter your email and we’ll reveal your result here and send you a copy.</p>
    <form class="email-result" @submit.prevent="reveal">
      <label for="qz-email" class="muted" style="display:block;font-weight:600;margin-bottom:.4rem">Email address</label>
      <div class="email-row">
        <input id="qz-email" v-model="email" type="email" placeholder="you@email.com" required>
        <button class="btn mt-4" type="submit" :disabled="emailing">{{ emailing ? 'Revealing…' : 'Show my result' }}</button>
      </div>
      <p v-if="emailError" class="error" style="margin-top:.5rem">{{ emailError }}</p>
    </form>
  </div>

  <div v-else>
    <div class="progress" role="progressbar" :aria-valuenow="step" :aria-valuemax="questions.length">
      <span :style="{ width: percent + '%' }"></span>
    </div>
    <p class="muted">Question {{ step + 1 }} of {{ questions.length }}</p>
    <h3>{{ current.text }}</h3>
    <div class="choices">
      <button v-for="o in current.options" :key="o.id" class="choice" @click="pick(o.id)">{{ o.text }}</button>
    </div>
    <p v-if="failed" class="error">Something went wrong. Try picking again.</p>
  </div>
</template>