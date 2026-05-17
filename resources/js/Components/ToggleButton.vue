<template>
  <div 
    class="flex items-center w-14 h-8 p-1 transition-colors duration-300 rounded-full cursor-pointer"
    :class="modelValue ? 'bg-green-500' : 'bg-gray-300'"
    @click="$emit('update:modelValue', !modelValue)"
  >
  
    <div 
      class="w-6 h-6 transition-transform duration-300 transform bg-white rounded-full shadow-md"
      :class="{ 'translate-x-6': modelValue }"
    ></div>
  </div>
</template>

<script setup>
  defineProps(['modelValue']);
  defineEmits(['update:modelValue']);
</script>