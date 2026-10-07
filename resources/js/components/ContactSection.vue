<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({ name: '', email: '', phone: '' });
const sending = ref(false);
const done = ref(false);
const error = ref('');

async function submit() {
  sending.value = true; error.value = ''; done.value = false;
  try {
    await axios.post('/api/contact', form.value);
    form.value = { name: '', email: '', phone: '' };
    done.value = true;
  } catch (e) {
    const errs = e.response?.data?.errors;
    error.value = errs ? Object.values(errs).flat().join(' ') : 'Something went wrong. Please try again.';
  } finally { sending.value = false; }
}
</script>

<template>
  <form class="contact-form" @submit.prevent="submit">
    <label for="c-name">Name</label>
    <input id="c-name" v-model="form.name" autocomplete="name" maxlength="100" required>

    <label for="c-email">Email address</label>
    <input id="c-email" v-model="form.email" type="email" autocomplete="email" maxlength="150" required>

    <label for="c-phone">Contact number</label>
    <input id="c-phone" v-model="form.phone" type="tel" autocomplete="tel" maxlength="20" placeholder="0917 123 4567" required>

    <p class="muted small">We’ll only use your details to contact you about Passport Lounge.</p>
    <p v-if="error" class="error" role="alert">{{ error }}</p>
    <p v-if="done" class="ok" role="status">Thanks! We’ll be in touch.</p>
    <button class="btn" type="submit" :disabled="sending">{{ sending ? 'Sending…' : 'Send' }}</button>
  </form>
</template>
