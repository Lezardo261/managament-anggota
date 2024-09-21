<template>
    <transition name="fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
      <div v-if="visible" class="notification" :class="type">
        {{ message }}
      </div>
    </transition>
</template>
  
<script setup>
import { ref, watch } from 'vue';
  
const props = defineProps({
  message: String,
  type: String,
  duration: Number,
});
  
const visible = ref(true);
  
watch(() => props.message, (newMessage) => {
  if (newMessage) {
    visible.value = true;
    setTimeout(() => {
      visible.value = false;
    }, props.duration || 5000);
  } else {
    visible.value = false; // Hide notification immediately if message is cleared
  }
});

    
const beforeEnter = (el) => {
  el.style.transform = 'translateY(100%)';
};
  
const enter = (el, done) => {
  el.offsetHeight; // trigger reflow
  el.style.transition = 'transform 0.3s ease-out';
  el.style.transform = 'translateY(0)';
  done();
};
  
const leave = (el, done) => {
  el.style.transition = 'transform 0.3s ease-in';
  el.style.transform = 'translateY(100%)';
  done();
};
</script>
  
<style scoped>
.notification {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #333;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  z-index: 9999;
}
  
.notification.success {
  background: #4caf50;
}
  
.notification.error {
  background: #f44336;
}
</style>
  