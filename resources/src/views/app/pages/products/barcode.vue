<template>
  <div class="main-content">
    <breadcumb :page="$t('Printbarcode')" :folder="$t('Assets')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <!-- <b-card v-if="!isLoading"> -->
      <b-row v-if="!isLoading">
 
 

        <b-col md="12">
      
    
          <button
            @click="print_Bracode('print_barcode')"
            value="Print"
            type="submit"
            class="btn btn-light btn-sm pull-right m-1">
            <i class="i-Billing"></i>
            {{$t('print')}}
          </button>
        </b-col>
      
      

            <b-col md="12">
              <div class="barcode-row"  id="print_barcode_label">
                <!-- <div :class="class_type_page" v-for ="(k, i) in total_a4" :key="i">
                  <div class="barcode-item" :class="class_sheet"  v-for="(sheet, index) in sheets" :key="index" >
                      <span class="barcode-name">{{asset.ar_name}}</span>
                    <barcode
                      class="barcode"
                      :format="barcodeType"
                      :value="asset.id"
                      textmargin="0"
                      fontoptions="bold"
                      fontSize= "15"
                      height= "25"
                      width= "1"
                    ></barcode>
                    </div>
                </div> -->
                <!-- <div :class="class_type_page"  v-if="rest > 0"> -->


                  <div class="barcode-item" style="width: 100%;  text-align: center; "      >
                      <!-- <span  class="barcode-name">{{index}}</span> -->
                    <barcode
                    style="width: 100%;"
                      class="barcode"
                      fontSize= "15"
                      :format="barcodeType"
                      :value="room.uuid"
                      textmargin="0"
                      fontoptions="bold"
                      height= "40"
                      width= "4"
                    ></barcode>

                    <span    >{{room.ar_name}}</span>


                    </div>


                  <div class="barcode-item" style="width: 100%;  text-align: center; "    v-for="(item, index) in items" :key="index" >
                      <!-- <span  class="barcode-name">{{index}}</span> -->
                    <barcode
                    style="width: 100%;"
                      class="barcode"
                      fontSize= "15"
                      :format="barcodeType"
                      :value="item.uuid"
                      textmargin="0"
                      fontoptions="bold"
                      height= "40"
                      width= "4"
                    ></barcode>

                    <span    >{{item.ar_name}}</span>


                    </div>
                <!-- </div> -->
              </div>
            </b-col>
          </b-row>
          </div>
      
</template>

<script>
import VueBarcode from "vue-barcode";
import NProgress from "nprogress";

export default {
  components: {
    barcode: VueBarcode
  },
  data() {
    return {
      focused: false,
      timer:null,
      search_input:'',
      asset_filter:[],
      isLoading: true,
      ShowCard: false,
      barcodeType:"CODE128",
      barcode: {
        asset_id: "",
        warehouse_id: "",
        qte: 2
      },
      count: "",
      paper_size:"",
      sheets:'',
      total_a4:'',
      class_sheet:'',
      class_type_page:'',
      rest:[1,2,3,5],     
      warehouses: [],
      submitStatus: null,
      assets: [],
      items:[],
      room:{
      uuid:"",
      ar_name:"",
      },
      asset: {
        ar_name: "",
        id: "",
 
      }
    };
  },

  methods: {
    loadBarcode(){
      let id = this.$route.params.id;
      this.Get_Elementst();
    },


    Per_Page(){
      this.total_a4 = parseInt(1);
      // this.total_a4 = parseInt(this.barcode.qte/this.sheets);
      this.rest = this.barcode.qte%this.sheets;
    },

 //---------------------- Event Selected_Paper_size------------------------------\\
    Selected_Paper_size(value) {

      
      if(value == 'style40'){
        this.sheets = 40;
        this.class_sheet = 'style10';
        this.class_type_page = 'barcodea4';
      }else if(value == 'style30'){
        this.sheets = 30;
        this.class_type_page = 'barcode_non_a4';
        this.class_sheet = 'style30';
      }else if(value == 'style24'){
        this.sheets = 24;
        this.class_sheet = 'style24';
       this.class_type_page = 'barcodea4';
      }else if(value == 'style20'){
        this.sheets = 20;
        this.class_sheet = 'style20';
        this.class_type_page = 'barcode_non_a4';
      }else if(value == 'style18'){
        this.sheets =  18;
        this.class_sheet = 'style18';
        this.class_type_page = 'barcodea4';
      }else if(value == 'style14'){
        this.sheets = 14;
        this.class_sheet = 'style14';
        this.class_type_page = 'barcode_non_a4';
      }else if(value == 'style12'){
        this.sheets = 12;
        this.class_sheet = 'style12';
       this.class_type_page = 'barcodea4';
      }else if(value == 'style10'){
        this.sheets = 10;
        this.class_sheet = 'style10';
       this.class_type_page = 'barcode_non_a4';
      }else if(value == 'style1'){
        this.sheets = 1;
        this.class_sheet = 'style10';
       this.class_type_page = 'barcodea4';
      }
     
      this.Per_Page();
    },


    //------ Validate Form
    submit() {
      this.showBarcode();

 
    },

    //---Validate State Fields
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

      handleFocus() {
      this.focused = true
    },

    handleBlur() {
      this.focused = false
    },
    

   // Search Assets
    search(){

      if (this.timer) {
            clearTimeout(this.timer);
            this.timer = null;
      }

      if (this.search_input.length < 1) {

        return this.asset_filter= [];


      }
    
         this.timer = setTimeout(() => {
        
         this.asset_filter = this.assets.filter(asset => {
            return (
                asset.ar_name.toLowerCase().startsWith(this.search_input.toLowerCase())  
         
               
                );
              });
        }, 800);
 


    },

    //------ Search Result value
    getResultValue(result) {
      return result.id + " " + "(" + result.ar_name + ")";
    },

    //------ Submit Search Asset
    SearchAsset(result) {
      this.asset = {};
      if (this.asset.id === result.id) {
        this.makeToast("warning", this.$t("AlreadyAdd"), this.$t("Warning"));
      } else {
        this.asset.id = result.id;
        this.asset.ar_name = result.ar_name;
 
      }

      this.search_input= '';
      this.asset_filter = [];
    },

    //------ Toast
    makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },

    //------------------------------------ Get Assets By Warehouse -------------------------\\

    Get_Assets_By_Warehouse(id) {
      // Start the progress bar.

      // axios.get("Assets/Warehouse/" + id + "?stock=" + 0).then(response => {
        NProgress.start();
        NProgress.set(0.1);
        axios.get("Assets/barcode/all").then(response => {
            this.assets = response.data.assets;
            console.log(response.data.assets)
             NProgress.done();

            })
          .catch(error => {
          });
    },

    //-------------------------------------- Print Barcode -------------------------\\

    print_Bracode() {
      var divContents = document.getElementById("print_barcode_label").innerHTML;
      var a = window.open("", "", "height=500, width=500");
      a.document.write(
        '<link rel="stylesheet" href="/assets_setup/css/print_label.css"><html>'
      );
      a.document.write("<body >");
      a.document.write(divContents);
      a.document.write("</body></html>");
      a.document.close();
      a.print();
    },
   
    //-------------------------------------- Show Barcode -------------------------\\
    showBarcode() {
      this.Per_Page();
      this.count = this.barcode.qte;
      this.ShowCard = true;
    },

    //---------------------- Event Select Warehouse ------------------------------\\
    Selected_Warehouse(value) {
      this.search_input= '';
      this.asset_filter = [];
      this.Get_Assets_By_Warehouse(value);
    },

    //----------------------------------- GET Barcode Elements -------------------------\\
    Get_Elementst() {
      let id = this.$route.params.id;
      axios.get("Items/barcode/"+id).then(response => {
          this.items = response.data.items;
          this.room.ar_name = response.data.room_name;
          this.room.uuid = response.data.uuid;
          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    },

    //----------------------------------- Reset Data -------------------------\\
    reset() {
      this.ShowCard = false;
      this.assets = [];
      this.asset.name = "";
      this.asset.code = "";
      this.barcode.qte = 10;
      this.count = 10;
      this.barcode.warehouse_id = "";
      this.search_input= '';
      this.asset_filter = [];
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    // this.Get_Assets_By_Warehouse(2);
    // this.Get_Elements();
    this.loadBarcode();
  }
};
</script>