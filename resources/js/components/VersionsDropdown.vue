<template>
    <div class="btn-group ">
        <a class="dropdown-toggle" style="cursor: pointer" data-bs-toggle="dropdown" aria-expanded="false">
            {{selected.semver}}
        </a>
        <ul class="dropdown-menu">
            <li
                v-for="(version, i) of versions"
                :key="i"
                @click="
                  selected = version;
                  "
                style="cursor: pointer"
            >
                <span class="dropdown-item">{{version.semver}}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "VersionsDropdown",
    data(){
      return {
          selected: this.default
      }
    },
    props: {
        versions: {
            type: Array,
            required: true,
        },
        default: {
            type: Object,
            required: true,
        },
    },
   watch: {
        selected: function (newVal) {
            this.$emit('input', newVal)
        }
   }
}
</script>

<style scoped>

</style>
