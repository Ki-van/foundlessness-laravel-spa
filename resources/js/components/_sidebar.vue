<template>
    <v-navigation-drawer  permanent>
    <v-list-item>
        <v-list-item-content>
            <v-list-item-title class="text-h6">
                Foundlessness Admin
            </v-list-item-title>
        </v-list-item-content>
    </v-list-item>

    <v-divider/>
  <v-list dense nav>
    <v-list-item exact to="/admin">
      <v-list-item-action>
        <v-icon>mdi-view-dashboard</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>Dashboard</v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-list-group prepend-icon="mdi-account-circle">
        <template v-slot:activator>
            <v-list-item-title>User Management</v-list-item-title>
        </template>

      <v-list-item to="/admin/users">
        <v-list-item-action>
          <v-icon>mdi-account_circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Users</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/roles">
        <v-list-item-action>
          <v-icon>mdi-account_circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Roles</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/permissions">
        <v-list-item-action>
          <v-icon>mdi-account_circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Permissions</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group>

    <v-list-item to="/admin/activities">
      <v-list-item-action>
        <v-icon>mdi-settings</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>Activities</v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-list-item to="/admin/settings">
      <v-list-item-action>
        <v-icon>mdi-settings</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>Settings</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
    </v-navigation-drawer>
</template>


<script>
export default {

}

</script>


