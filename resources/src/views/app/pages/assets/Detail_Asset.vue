
<template>
  <div class="main-content">
    <breadcumb :page="$t('AssetDetails')" :folder="$t('Assets')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <b-card no-body v-if="!isLoading">
      <b-card-header>
        <button @click="print_asset()" class="btn btn-outline-primary">
          <i class="i-Billing"></i>
          {{  $t('print') }}
        </button>
      </b-card-header>
      <b-card-body>
        <b-row >
          
          <b-col id="print_asset" md="12" class="mb-5">
            <barcode
              class="barcode"
               format="CODE128"
              :value="asset.id"
              textmargin="0"
              fontoptions="bold"
            ></barcode>
          </b-col>
      
          <b-col md="8">
            <table class="table table-hover table-bordered table-md">
              <tbody>
                <tr>
                  <td> {{  $t('name') }}</td>
                  <th> {{  asset.ar_name  }}</th>
                </tr>
      


                <tr>
                  <td> {{  $t('category')  }}</td>
                  <th> {{  asset.category   }}</th>
                </tr>

                <tr>
                  <td> {{  $t('Group')  }}</td>
                  <th> {{  asset.group   }}</th>
                </tr>


                <tr>
                  <td> {{  $t('Employee')  }}</td>
                  <th> {{  asset.client   }}</th>
                </tr>

                <tr>
                  <td> {{  $t('Location')  }}</td>
                  <th> {{  asset.location   }}</th>
                </tr>
 
              </tbody>
            </table>
          </b-col>
          <b-col md="4" class="mb-30">
            <div class="carousel_wrap">
              <b-carousel
                id="carousel-1"
                :interval="2000"
                controls
                background="#ababab"
                img-width="1024"
                img-height="480"
                @sliding-start="onSlideStart"
                @sliding-end="onSlideEnd"
              >
                <b-carousel-slide
                  v-for="(image, index) in asset.images"
                  :key="index"
                  :img-src="'/images/assets/'+image"
                ></b-carousel-slide>
              </b-carousel>
            </div>
          </b-col>

          <!-- Warehouse Quantity -->
          <b-col md="5" class="mt-4">
            <table class="table table-hover table-sm">
          
     
            </table>
          </b-col>
          <!-- Warehouse Variants Quantity -->
  
        </b-row>
      </b-card-body>
    </b-card>
  </div>
</template>


<script>
import VueBarcode from "vue-barcode";
import { mapActions, mapGetters } from "vuex";

export default {
  metaInfo: {
    title: "Detail Asset"
  },
  components: {
    barcode: VueBarcode
  },

  data() {
    return {
      len: 8,
      images: [],
      imageArray: [],
      isLoading: true,
      asset: {},
      roles: {},
      variants: []
    };
  },
  computed: {
    ...mapGetters(["currentUser"])
  },

  methods: {
    //------- printasset
    print_asset() {
      var divContents = document.getElementById("print_asset").innerHTML;
      var a = window.open("", "", "height=500, width=500");
      a.document.write(
        '<link rel="stylesheet" href="/assets_setup/css/bootstrap.css"><html>'
      );
      a.document.write("<body >");
      a.document.write(divContents);
      a.document.write("</body></html>");
      a.document.close();
      a.print();
    },

    //------------------------------Formetted Numbers -------------------------\
    formatNumber(number, dec) {
      const value = (typeof number === "string"
        ? number
        : number.toString()
      ).split(".");
      if (dec <= 0) return value[0];
      let formated = value[1] || "";
      if (formated.length > dec)
        return `${value[0]}.${formated.substr(0, dec)}`;
      while (formated.length < dec) formated += "0";
      return `${value[0]}.${formated}`;
    },

    //----------------------------------- Get Details Asset ------------------------------\
    showDetails() {
      let id = this.$route.params.id;
      axios
        .get(`Assets/Detail/${id}`)
        .then(response => {
          this.asset = response.data;
          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    this.showDetails();
  }
};
</script>