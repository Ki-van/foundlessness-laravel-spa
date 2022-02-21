<template>
  <v-app-bar app >
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    <v-toolbar-title>Laravel Vue Admin</v-toolbar-title>
    <v-spacer></v-spacer>

    <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
      <v-btn icon large text v-slot="activator">
        <v-avatar size="30px">
          <img src="https://via.placeholder.com/150" alt="Michael Wang">
        </v-avatar>
      </v-btn>
      <v-list class="pa-0">
        <v-list-item ripple="ripple" rel="noopener">
          <v-list-item-content>
            <v-list-item-title>{{user.name}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list class="pa-0">
        <v-list-item @click="logout" ripple="ripple" rel="noopener">
          <v-list-item-action>
            <v-icon>mdi-account_circle</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>


<script>
export default {
  data: () => ({
    drawer: null,
    allNotifications: null,
    unreadNotifications: [],
  }),
  props: ["user"],
  watch:{
      allNotifications(val){
          this.unreadNotifications =  this.allNotifications.filter(notification => {
            return notification.read_at == null;
        });
      }
  },

  methods: {
    logout() {
      axios.post("/logout").then(response => window.location.reload());
    },
    markAsRead() {
      axios.get("/mark-all-read/" + this.user.id).then(response=>{
          this.unreadNotifications = [];
      });
    }
  },

  created() {
   /* this.allNotifications = this.user.notifications;

    this.unreadNotifications =  this.allNotifications.filter(notification => {
        return notification.read_at == null;
      });
*/
    // Echo.private("App.User." + this.user.id).notification(notification => {
    //   this.allNotifications.unshift(notification.notification);
    // });
  }
};
</script>
