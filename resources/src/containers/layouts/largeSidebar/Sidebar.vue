<template>
  <div
    class="side-content-wrap"
    @mouseenter="isMenuOver = true"
    @mouseleave="isMenuOver = false"
    @touchstart="isMenuOver = true"
  >
    <vue-perfect-scrollbar
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
      :class="{ open: getSideBarToggleProperties.isSideNavOpen }"
      ref="myData"
      class="sidebar-left rtl-ps-none ps scroll"
    >
      <div>
        <ul class="navigation-left">
          <li
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'dashboard' }"
            class="nav-item"
            data-item="dashboard"
          >
            <router-link tag="a" class="nav-item-hold" to="/app/dashboard">
              <i class="nav-icon i-Bar-Chart"></i>
              <span class="nav-text">{{ $t("dashboard") }}</span>
            </router-link>
          </li>
 
          
          <li
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'Categories' }"
            class="nav-item"
            data-item="Categories"
          >
            <router-link tag="a" class="nav-item-hold" to="/app/settings/Categories">
              <img src="https://cdn-icons-png.flaticon.com/512/6736/6736258.png" width="50%"/> 
              <span class="nav-text">{{ $t("Categories") }}</span>
            </router-link>
          </li>


          

          

          <!-- <li
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'Groups' }"
            class="nav-item"
            data-item="Groups">
            <router-link tag="a" class="nav-item-hold" to="/app/settings/Groups">
              <img src="https://cdn-icons-png.flaticon.com/512/5377/5377567.png" width="50%"/> 
              <span class="nav-text">{{ $t("Group") }}</span>
            </router-link>
          </li> -->


          
           

           

          

          <li
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'Locations' }"
            class="nav-item"
            data-item="Locations">
            <router-link tag="a" class="nav-item-hold" to="/app/settings/Locations">
              <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" width="50%"/> 
              <span class="nav-text">{{ $t("Location") }}</span>
            </router-link>
          </li>




          <li @mouseenter="toggleSubMenu"
            class="nav-item"
            :class="{ active: selectedParentMenu == 'assets' }"
            data-item="assets"
            :data-submenu="true">
            <a class="nav-item-hold" href="#">
              <img src="https://cdn-icons-png.flaticon.com/512/5540/5540319.png" width="50%"/> 
              <span class="nav-text">{{   $t('Assets')  }}</span>
            </a>
            <div class="triangle"></div>
          </li>
         
          
   

          <li
            class="nav-item">
            <router-link tag="a" class to="/app/settings/Inventores">
              <img src="https://cdn-icons-png.flaticon.com/512/10998/10998071.png " width="50%"/> 
              <span class="item-name">{{  $t('Inventore')  }}</span>
            </router-link>
          </li>



          <!-- <li
            class="nav-item">
            <router-link tag="a" class to="/app/settings/Builds">
              <i class="nav-icon i-Bookmark"></i>
              <span class="item-name">{{   $t('Build') }}</span>
            </router-link>
          </li> -->


          <li 
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'People' }"
            class="nav-item"
            data-item="People"
            :data-submenu="true"
          >
            <a class="nav-item-hold" href="#">
              <i class="nav-icon i-Business-Mens"></i>
              <span class="nav-text">{{$t('users')}}</span>
            </a>
            <div class="triangle"></div>
          </li>

          <li v-show="currentUserPermissions && (currentUserPermissions.includes('setting_system') 
                        || currentUserPermissions.includes('warehouse') || currentUserPermissions.includes('brand')
                        || currentUserPermissions.includes('backup')    || currentUserPermissions.includes('unit')
                        || currentUserPermissions.includes('currency')  || currentUserPermissions.includes('category')
                        || currentUserPermissions.includes('permissions_view'))"
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'settings' }"
            class="nav-item"
            data-item="settings"
            :data-submenu="true">

            <a class="nav-item-hold" href="#">
              <img src="https://cdn-icons-png.flaticon.com/512/2721/2721681.png" width="50%"/> 
              <span class="nav-text">{{$t('Settings')}}</span>
            </a>

            <div class="triangle"></div>
          </li>
<!-- 
          <li
            v-show="currentUserPermissions && 
                     (currentUserPermissions.includes('Reports_payments_Sales') 
                     || currentUserPermissions.includes('Reports_payments_Purchases')
                     || currentUserPermissions.includes('Reports_payments_Sale_Returns')
                     || currentUserPermissions.includes('Reports_payments_purchase_Return')
                     || currentUserPermissions.includes('Warehouse_report')
                     || currentUserPermissions.includes('Reports_profit')
                     || currentUserPermissions.includes('Reports_purchase') 
                     || currentUserPermissions.includes('Reports_quantity_alerts')
                     || currentUserPermissions.includes('Reports_sales') 
                     || currentUserPermissions.includes('Reports_suppliers')
                     || currentUserPermissions.includes('Reports_customers'))"
            @mouseenter="toggleSubMenu"
            :class="{ active: selectedParentMenu == 'reports' }"
            class="nav-item"
            data-item="reports"
            :data-submenu="true"
          >
            <a class="nav-item-hold" href="#">
              <i class="nav-icon i-Line-Chart"></i>
              <span class="nav-text">{{$t('Reports')}}</span>
            </a>
            <div class="triangle"></div>
          </li>         -->
        </ul>
      </div>
    </vue-perfect-scrollbar>

    <vue-perfect-scrollbar
      :class="{ open: getSideBarToggleProperties.isSecondarySideNavOpen }"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
      class="sidebar-left-secondary ps rtl-ps-none"
    >
      <div ref="sidebarChild">
 


        
        <ul
          class="childNav d-none"
          data-parent="assets"
          :class="{ 'd-block': selectedParentMenu == 'assets' }">

     


          <li
            class="nav-item"
             >
            <router-link tag="a" class to="/app/assets/list">
              <i class="nav-icon i-Files"></i>
              <span class="item-name">{{  $t('assetsList') }}</span>
            </router-link>
          </li>

          <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('barcode_view')"
          >
            <router-link tag="a" class to="/app/products/barcode">
              <i class="nav-icon i-Bar-Code"></i>
              <span class="item-name">{{$t('Printbarcode')}}</span>
            </router-link>
          </li>
 
        </ul>
  
 

        

        <ul
          class="childNav d-none"
          data-parent="People"
          :class="{ 'd-block': selectedParentMenu == 'People' }"
        >
  
    
          <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('users_view')"
          >
            <router-link tag="a" class to="/app/People/Users">
              <i class="nav-icon i-Administrator"></i>
              <span class="item-name">{{$t('Users')}}</span>
            </router-link>
          </li>
        </ul>

        <ul
          class="childNav d-none"
          data-parent="settings"
          :class="{ 'd-block': selectedParentMenu == 'settings' }"
        >
          <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('setting_system')"
          >
            <router-link tag="a" class to="/app/settings/System_settings">
              <i class="nav-icon i-Data-Settings"></i>
              <span class="item-name">{{$t('SystemSettings')}}</span>
            </router-link>
          </li>
 
 


<!-- 
          <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('category')"
          >
            <router-link tag="a" class to="/app/settings/Categories">
              <i class="nav-icon i-Duplicate-Layer"></i>
              <span class="item-name">{{$t('Categories')}}</span>
            </router-link>
          </li>
 


          <li class="nav-item">
            <router-link tag="a" class to="/app/settings/Groups">
              <i class="nav-icon i-Bookmark"></i>
              <span class="item-name">{{   $t('Group') }}</span>
            </router-link>
          </li>

          <li
            class="nav-item" >
            <router-link tag="a" class to="/app/settings/Locations">
              <i class="nav-icon i-Bookmark"></i>
              <span class="item-name">{{   $t('Location') }}</span>
            </router-link>
          </li> -->

 
<!--     
          <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('backup')"
          >
            <router-link tag="a" class to="/app/settings/Backup">
              <i class="nav-icon i-Data-Backup"></i>
              <span class="item-name">{{$t('Backup')}}</span>
            </router-link>
          </li> -->

           <!-- <li
            class="nav-item"
            v-if="currentUserPermissions && currentUserPermissions.includes('setting_system')"
          >
            <router-link tag="a" class to="/app/settings/updates">
              <i class="nav-icon i-Data-Upload"></i>
              <span class="item-name">{{$t('Updates')}}</span>
            </router-link>
          </li> -->
        </ul>

 
      </div>
    </vue-perfect-scrollbar>
    <div
      @click="removeOverlay()"
      class="sidebar-overlay"
      :class="{ open: getSideBarToggleProperties.isSecondarySideNavOpen }"
    ></div>
  </div>
  <!--=============== Left side End ================-->
</template>

<script>
import Topnav from "./TopNav";
import { isMobile } from "mobile-device-detect";

import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Topnav
  },

  data() {
    return {
      isDisplay: true,
      isMenuOver: false,
      isStyle: true,
      selectedParentMenu: "",
      isMobile
    };
  },
  mounted() {
    this.toggleSelectedParentMenu();
    window.addEventListener("resize", this.handleWindowResize);
    document.addEventListener("click", this.returnSelectedParentMenu);
    this.handleWindowResize();
  },

  beforeDestroy() {
    document.removeEventListener("click", this.returnSelectedParentMenu);
    window.removeEventListener("resize", this.handleWindowResize);
  },

  computed: {
    ...mapGetters(["getSideBarToggleProperties", "currentUserPermissions"])
  },

  methods: {
    ...mapActions([
      "changeSecondarySidebarProperties",
      "changeSecondarySidebarPropertiesViaMenuItem",
      "changeSecondarySidebarPropertiesViaOverlay",
      "changeSidebarProperties"
    ]),

    handleWindowResize() {
      if (window.innerWidth <= 1200) {
        if (this.getSideBarToggleProperties.isSideNavOpen) {
          this.changeSidebarProperties();
        }
        if (this.getSideBarToggleProperties.isSecondarySideNavOpen) {
          this.changeSecondarySidebarProperties();
        }
      } else {
        if (!this.getSideBarToggleProperties.isSideNavOpen) {
          this.changeSidebarProperties();
        }
      }
    },
    toggleSelectedParentMenu() {
      const currentParentUrl = this.$route.path
        .split("/")
        .filter(x => x !== "")[1];
      if (currentParentUrl !== undefined || currentParentUrl !== null) {
        this.selectedParentMenu = currentParentUrl.toLowerCase();
      } else {
        this.selectedParentMenu = "dashboard";
      }
    },
    toggleSubMenu(e) {
      let hasSubmenu = e.target.dataset.submenu;
      let parent = e.target.dataset.item;

      if (hasSubmenu) {
        this.selectedParentMenu = parent;

        this.changeSecondarySidebarPropertiesViaMenuItem(true);
      } else {
        this.selectedParentMenu = parent;
        this.changeSecondarySidebarPropertiesViaMenuItem(false);
      }
    },

    removeOverlay() {
      this.changeSecondarySidebarPropertiesViaOverlay();
      if (window.innerWidth <= 1200) {
        this.changeSidebarProperties();
      }
      this.toggleSelectedParentMenu();
    },
    returnSelectedParentMenu() {
      if (!this.isMenuOver) {
        this.toggleSelectedParentMenu();
      }
    },

    toggleSidebarDropdwon(event) {
      let dropdownMenus = this.$el.querySelectorAll(".dropdown-sidemenu.open");

      event.currentTarget.classList.toggle("open");

      dropdownMenus.forEach(dropdown => {
        dropdown.classList.remove("open");
      });
    }
  }
};
</script>

<style lang="" scoped>
</style>

