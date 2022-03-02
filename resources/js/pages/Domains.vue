<template>
<div>
    <div v-if="loading" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
        </div>
    </div>
    <DomainPreview v-for="domain in domains" :key="domain.id" :domain="domain"/>
</div>
</template>

<script>
import DomainPreview from "../components/DomainPreview";
export default {
    name: "Domains",
    components: {DomainPreview},
    data(){
      return {
          loading: false,
          domains: []
      }
    },
    methods: {
      init(){
          this.loading = true;
          this.$store.dispatch('article/getDomains').then(response => {
              this.loading = false;
              this.domains = response;
          });
      }
    },
    created() {
       this.init();
    }
}
</script>

<style scoped>

</style>
