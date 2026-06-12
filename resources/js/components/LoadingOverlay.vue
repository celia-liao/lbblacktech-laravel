<template>
  <section class="loading-overlay">
    <div class="images-container">
      <div class="image-left">
        <img 
          :src="assetUrl(`storage/pets/${slug}/image/loading/people/human.svg`)" 
          alt="飼主" 
        />
      </div>
      <div class="image-right">
        <img 
          :src="assetUrl(`storage/pets/${slug}/image/loading/pet/pet.svg`)" 
          alt="毛孩" 
        />
      </div>
      <div class="line"></div>
    </div>
    <div class="slogan">信念科技•全球首創</div>
    <div class="logo">
      <img 
        :src="assetUrl('assets/images/logotype.svg')" 
        alt="logo" 
      />
    </div>
  </section>
</template>

<script setup lang="ts">
import { useAsset } from '../composables/useAsset';

defineProps<{
  slug: string;
}>();

const { assetUrl } = useAsset();
</script>
