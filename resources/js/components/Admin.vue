<template>
  <div>
    <v-app id="inspire">
        <sidebar></sidebar>
        <navbar :user="user"></navbar>

      <v-main>
        <v-container fluid fill-height>
          <v-layout justify-center>
            <v-flex shrink>
              <router-view></router-view>
            </v-flex>
          </v-layout>
        </v-container>
      </v-main>
      <v-footer app fixed>
        <span>&copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>

<script>
import Sidebar from "./_sidebar";
import Navbar from "./_navbar";

export default {
  components: { Sidebar, Navbar },
  data: () => ({
    drawer: null
  }),
  computed: {
      user() {
          return this.$store.state.auth.user;
      }
  }
};
</script>
