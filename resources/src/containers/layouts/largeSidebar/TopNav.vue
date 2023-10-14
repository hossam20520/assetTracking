<template>
  <div class="main-header">
    <div class="logo">
       <router-link to="/app/dashboard">
        <img :src="'/images/'+currentUser.logo" alt width="60" height="60">
       </router-link>
    </div>

    <div @click="sideBarToggle" class="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>

    <div style="margin: auto"></div>
   
    <div class="header-part-right">
      <!-- <router-link 
        v-if="currentUserPermissions && currentUserPermissions.includes('Pos_view')"
        class="btn btn-outline-primary tn-sm btn-rounded"
        to="/app/pos"
      >
      <span class="ul-btn__text ml-1">POS</span>
      </router-link> -->
      <!-- Full screen toggle -->
      <!-- <i class="i-Full-Screen header-icon d-none d-sm-inline-block" @click="handleFullScreen"></i> -->
      <!-- Grid menu Dropdown -->

 
      <!-- Notificaiton End -->

      <!-- User avatar dropdown -->
      <div class="dropdown">
        <b-dropdown
          id="dropdown-1"
          text="Dropdown Button"
          class="m-md-2 user col align-self-end d-md-block"
          toggle-class="text-decoration-none"
          no-caret
          variant="link"
        >
          <template slot="button-content" >
            <img
              :src="'/images/avatar/'+currentUser.avatar"
              id="userDropdown"
              alt
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
          </template>

          <div class="dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-header">
              <i class="i-Lock-User mr-1"></i> <span >{{currentUser.username}}</span>
            </div>
            <router-link to="/app/profile" class="dropdown-item">{{$t('profil')}}</router-link>
            <router-link
              v-if="currentUserPermissions && currentUserPermissions.includes('setting_system')"
              to="/app/settings/System_settings"
              class="dropdown-item"
            >{{$t('Settings')}}</router-link>
            <a class="dropdown-item" href="#" @click.prevent="logoutUser">{{$t('logout')}}</a>
          </div>
        </b-dropdown>
      </div>
    </div>
  </div>

  <!-- header top menu end -->
</template>
<script>
import Util from "./../../../utils";
// import Sidebar from "./Sidebar";
import { isMobile } from "mobile-device-detect";
import { mapGetters, mapActions } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
// import { setTimeout } from 'timers';
import FlagIcon from "vue-flag-icon";

export default {
  mixins: [clickaway],
  components: {
    FlagIcon
  },

  data() {
  
    return {
      langs: [
        "en",
        "fr",
        "ar",
        "de",
        "es",
        "it",
        "Ind",
        "thai",
        "tr_ch",
        "sm_ch",
        "tur",
        "ru",
        "hn",
        "vn"
      ],
      
      isDisplay: true,
      isStyle: true,
      isSearchOpen: false,
      isMouseOnMegaMenu: true,
      isMegaMenuOpen: false,
      is_Load:false,
      // alerts:0,
     
    };
  },
 
   computed: {
     
     ...mapGetters([
       "currentUser",
      "getSideBarToggleProperties",
      "currentUserPermissions",
      "notifs_alert",
    ]),


  },

  methods: {
    
    ...mapActions([
      "changeSecondarySidebarProperties",
      "changeSidebarProperties",
      "changeThemeMode",
      "logout",
    ]),

    logoutUser() {
      this.$store.dispatch("logout");
    },

    SetLocal(locale) {
      this.$i18n.locale = locale;
      this.$store.dispatch("language/setLanguage", locale);
      Fire.$emit("ChangeLanguage");
    },

    handleFullScreen() {
      Util.toggleFullScreen();
    },
    logoutUser() {
      this.logout();
    },

    closeMegaMenu() {
      this.isMegaMenuOpen = false;
    },
    toggleMegaMenu() {
      this.isMegaMenuOpen = !this.isMegaMenuOpen;
    },
    toggleSearch() {
      this.isSearchOpen = !this.isSearchOpen;
    },

    sideBarToggle(el) {
      if (
        this.getSideBarToggleProperties.isSideNavOpen &&
        this.getSideBarToggleProperties.isSecondarySideNavOpen &&
        isMobile
      ) {
        this.changeSidebarProperties();
        this.changeSecondarySidebarProperties();
      } else if (
        this.getSideBarToggleProperties.isSideNavOpen &&
        this.getSideBarToggleProperties.isSecondarySideNavOpen
      ) {
        this.changeSecondarySidebarProperties();
      } else if (this.getSideBarToggleProperties.isSideNavOpen) {
        this.changeSidebarProperties();
      } else if (
        !this.getSideBarToggleProperties.isSideNavOpen &&
        !this.getSideBarToggleProperties.isSecondarySideNavOpen &&
        !this.getSideBarToggleProperties.isActiveSecondarySideNav
      ) {
        this.changeSidebarProperties();
      } else if (
        !this.getSideBarToggleProperties.isSideNavOpen &&
        !this.getSideBarToggleProperties.isSecondarySideNavOpen
      ) {

        this.changeSidebarProperties();
        this.changeSecondarySidebarProperties();
      }
    }
  }
};
</script>



