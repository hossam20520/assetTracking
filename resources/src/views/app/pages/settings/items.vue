
<template>
  <div class="main-content">
    <breadcumb :page="$t('Item')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="items"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        @on-search="onSearch"
        :search-options="{
        enabled: true,
        placeholder: $t('Search_this_table'),  
      }"
        :select-options="{ 
          enabled: true ,
          clearSelectionText: '',
        }"
        @on-selected-rows-change="selectionChanged"
        :pagination-options="{
        enabled: true,
        mode: 'records',
        nextLabel: 'next',
        prevLabel: 'prev',
      }"
        styleClass="table-hover tableOne vgt-table"
      >
        <div slot="selected-row-actions">
          <button class="btn btn-danger btn-sm" @click="delete_by_selected()"> {{ $t('Del') }}</button>
        </div>
        <div slot="table-actions" class="mt-2 mb-3">
          <b-button @click="New_Item()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>


          <!-- <b-button
            @click="Show_import_products()"
            size="sm"
            variant="info m-1"
           
          >
            <i class="i-Download"></i>
            {{ $t("import_products") }}
          </b-button> -->

        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <a @click="Edit_Item(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Item(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>



            <router-link
              v-b-tooltip.hover
              title="print"
              :to="{ name:'oneBarcode', params: { id: props.row.id ,    type: 'item' } }">
              <i class="i-QR-Code text-25 text-info"></i>
            </router-link>




          </span>

          <span v-else-if="props.column.field == 'image'">

            <b-img
            
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/items/' + props.row.image"
              alt="image"
            ></b-img>

          </span>




          <!-- 
          <span v-else-if="props.column.field == 'id'">
            <barcode
             style="width: 50px;"
              class="barcode"
               format="CODE128"
              :value="props.row.id"
              textmargin="0"
              fontoptions="bold"
            ></barcode>
          </span> 
          -->





        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_item">
      <b-modal hide-footer size="md" id="New_item" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Item" enctype="multipart/form-data">
          <b-row>
            <!-- Item Name -->


            
            <b-col md="12">
                  <validation-provider
                    name="ar_Name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('Name_ar_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('Enter_Name_ar_name')"
                        v-model="item.ar_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>


            
            <b-col md="12">
                  <validation-provider
                    name="uuid"
                    
                    v-slot="validationContext">
                    <b-form-group :label="$t('uuid')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="uuid"
                        :placeholder="$t('uuid')"
                        v-model="item.uuid"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>


               <!-- Category Major -->
               <b-col md="12" class="mb-2">
                  <validation-provider name="category" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('major_Categorie')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('major_Categorie')"
                        v-model="item.major_id"
                        :options="categories.map(categories => ({label: categories.name, value: categories.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>


                        <!-- Category Minor -->
                        <b-col md="12" class="mb-2">
                  <validation-provider name="category" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('minor_Categorie')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_minor_Category')"
                        v-model="item.minor_id"
                        :options="categories.map(categories => ({label: categories.name, value: categories.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                
            <!-- Category Detailed -->
            <b-col md="12" class="mb-2">
                  <validation-provider name="category" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('detaild_id')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('detaild_id')"
                        v-model="item.detaild_id"
                        :options="categories.map(categories => ({label: categories.name, value: categories.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



            
            <b-col md="12">
                  <validation-provider
                    name="orical_number"
                    :rules="{required:true , min:1 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('orical_number')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('orical_number')"
                        v-model="item.orical_number"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>
            
  
        
            <b-col md="12">
                  <validation-provider
                    name="room_number"
                    :rules="{required:true , min:1 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('room_number')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('room_number')"
                        v-model="item.room_number"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>

            

            <!-- -Item Image -->
            <b-col md="12">
              <validation-provider name="Image" ref="Image" rules="mimes:image/*|">
                <b-form-group slot-scope="{validate, valid, errors }" :label="$t('ItemImage')">
                  <input
                    :state="errors[0] ? false : (valid ? true : null)"
                    :class="{'is-invalid': !!errors.length}"
                    @change="onFileSelected"
                    label="Choose Image"
                    type="file"
                  >
                  <b-form-invalid-feedback id="Image-feedback">{{  errors[0]  }}</b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <b-col md="12" class="mt-3">
              <b-button variant="primary" type="submit"  :disabled="SubmitProcessing"> {{  $t('submit') }}</b-button>
                <div v-once class="typo__p" v-if="SubmitProcessing">
                  <div class="spinner sm spinner-primary mt-3"></div>
                </div>
            </b-col>

          </b-row>
        </b-form>
      </b-modal>
    </validation-observer>




    <b-modal
        ok-only
        ok-title="Cancel"
        size="md"
        id="importProducts"
        :title="$t('import_items')"
      >
        <b-form @submit.prevent="Submit_import" enctype="multipart/form-data">
          <b-row>
            <!-- File -->
            <b-col md="12" sm="12" class="mb-3">
              <b-form-group>
                <input type="file" @change="onFileSelectedItem" label="Choose File">
                <b-form-invalid-feedback
                  id="File-feedback"
                  class="d-block"
                >{{$t('field_must_be_in_csv_format')}}</b-form-invalid-feedback>
              </b-form-group>
            </b-col>

             <b-col md="6" sm="12">
            <b-button type="submit" variant="primary" :disabled="ImportProcessing" size="sm" block>{{ $t("submit") }}</b-button>
              <div v-once class="typo__p" v-if="ImportProcessing">
                <div class="spinner sm spinner-primary mt-3"></div>
              </div>
          </b-col>

            <b-col md="6" sm="12">
              <b-button
                :href="'/import/exemples/import_products.csv'"
                variant="info"
                size="sm"
                block
              >{{ $t("Download_exemple") }}</b-button>
            </b-col>

            <b-col md="12" sm="12">
              <table class="table table-bordered table-sm mt-4">
                <tbody>
                  <tr>
                    <td>{{$t('room_id')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>

                  <tr>
                    <td>{{$t('room_name')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>


                  <tr>
                    <td>{{$t('category')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>


                  <tr>
                    <td>{{$t('items')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>


                  <tr>
                    <td>{{$t('category_id')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>



                  <tr>
                    <td>{{$t('status')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>


                  <tr>
                    <td>{{$t('purchase_date')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>
 
   
                </tbody>
              </table>
            </b-col>
          </b-row>
        </b-form>
      </b-modal>
  </div>
</template>

<script>
import NProgress from "nprogress";
import VueBarcode from "vue-barcode";
export default {
  metaInfo: {
    title: "Item"
  },
  components: {
    barcode: VueBarcode
  },
  data() {
    return {
      isLoading: true,
      SubmitProcessing:false,
      serverParams: {
        columnFilters: {},
        sort: {
          field: "id",
          type: "desc"
        },
        page: 1,
        perPage: 10
      },
      selectedIds: [],
      totalRows: "",
      search: "",
      data: new FormData(),
      editmode: false,
      items: [],
      limit: "10",
     categories:[], 
     ImportProcessing:false,
     import_products: "",
      item: {
        id: "",
        uuid:"",
        ar_name: "",
        en_name: "",
        image: "",
        purchase_date: new Date().toISOString().slice(0, 10),
       
        room_id:"",
 
        room_number:"",
        orical_number:"",
        major_id:"",
        minor_id:"",
        detaild_id:"",
      }
    };
  },
  computed: {
    columns() {
      return [
        {
          label: this.$t("ItemImage"),
          field: "image",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("barcode"),
          field: "uuid",
          tdClass: "text-left",
          thClass: "text-left"
        },
   
        {
          label: this.$t("ar_name"),
          field: "ar_name",
          tdClass: "text-left",
          thClass: "text-left"
        },



        {
          label: this.$t("Major"),
          field: "major",
          tdClass: "text-left",
          thClass: "text-left"
        },
 

        {
          label: this.$t("Minor"),
          field: "minor",
          tdClass: "text-left",
          thClass: "text-left"
        },


        {
          label: this.$t("Detailed"),
          field: "detaild",
          tdClass: "text-left",
          thClass: "text-left"
        },


        {
          label: this.$t("orical_number"),
          field: "orical_number",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("Action"),
          field: "actions",
          html: true,
          tdClass: "text-right",
          thClass: "text-right",
          sortable: false
        }
      ];
    }
  },

  methods: {

        //----------------------------------- Show import products -------------------------------\\
   Show_import_products() {
      this.$bvModal.show("importProducts");
    },

    //------------------------------ Event Import products -------------------------------\\
    onFileSelectedItem(e) {
      this.import_products = "";
      let file = e.target.files[0];
      let errorFilesize;

      if (file["size"] < 1048576) {
        // 1 mega = 1,048,576 Bytes
        errorFilesize = false;
      } else {
        this.makeToast(
          "danger",
          this.$t("file_size_must_be_less_than_1_mega"),
          this.$t("Failed")
        );
      }

      if (errorFilesize === false) {
        this.import_products = file;
      }
    },

    //----------------------------------------Submit  import products-----------------\\
    Submit_import() {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      var self = this;
      self.ImportProcessing = true;
      self.data.append("items", self.import_products);
      axios
        .post("Items/import/csv", self.data)
        .then(response => {
          self.ImportProcessing = false;
          if (response.data.status === true) {
            this.makeToast(
              "success",
              this.$t("Successfully_Imported"),
              this.$t("Success")
            );
            Fire.$emit("Event_import");
          } else if (response.data.status === false) {
            this.makeToast(
              "danger",
              this.$t("field_must_be_in_csv_format"),
              this.$t("Failed")
            );
          }
          // Complete the animation of theprogress bar.
          NProgress.done();
        })
        .catch(error => {
          self.ImportProcessing = false;
          // Complete the animation of theprogress bar.
          NProgress.done();
          this.makeToast(
            "danger",
            this.$t("Please_follow_the_import_instructions"),
            this.$t("Failed")
          );
        });
    },


    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Items(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Items(1);
      }
    },

    //---- Event on Sort Change
    onSortChange(params) {
      this.updateParams({
        sort: {
          type: params[0].type,
          field: params[0].field
        }
      });
      this.Get_Items(this.serverParams.page);
    },

    //---- Event Select Rows
    selectionChanged({ selectedRows }) {
      this.selectedIds = [];
      selectedRows.forEach((row, index) => {
        this.selectedIds.push(row.id);
      });
    },

    //---- Event on Search

    onSearch(value) {
      this.search = value.searchTerm;
      this.Get_Items(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Item
    Submit_Item() {
      this.$refs.Create_item.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Item();
          } else {
            this.Update_Item();
          }
        }
      });
    },

    //------ Toast
    makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },

    //------------------------------ Event Upload Image -------------------------------\
    async onFileSelected(e) {
      const { valid } = await this.$refs.Image.validate(e);

      if (valid) {
        this.item.image = e.target.files[0];
      } else {
        this.item.image = "";
      }
    },

    //------------------------------ Modal (create Item) -------------------------------\
    New_Item() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_item");
    },

    //------------------------------ Modal (Update Item) -------------------------------\
    Edit_Item(item) {
      this.Get_Items(this.serverParams.page);
      this.reset_Form();
      this.item = item;
      this.editmode = true;
      this.$bvModal.show("New_item");
    },

    //---------------------------------------- Get All items-----------------\
    Get_Items(page) {
      // Start the progress bar.
      let id = this.$route.params.id
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "items?page=" +
            page +
            "&SortField=" +
            this.serverParams.sort.field +
            "&SortType=" +
            this.serverParams.sort.type +
            "&search=" +
            this.search +
            "&id=" +
             id+
            "&limit=" +
            this.limit
        )
        .then(response => {
          this.items = response.data.items;
          this.totalRows = response.data.totalRows;
          this.categories = response.data.categories;

          // Complete the animation of theprogress bar.
          NProgress.done();
          this.isLoading = false;
        })
        .catch(response => {
          // Complete the animation of theprogress bar.
          NProgress.done();
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    },

    //---------------------------------------- Create new item-----------------\
    Create_Item() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("ar_name", self.item.ar_name);
      self.data.append("room_id",  this.$route.params.id);
      self.data.append("category_id", self.item.category_id);

      self.data.append("purchase_date", self.item.purchase_date);
      self.data.append("uuid", self.item.uuid);
 
      self.data.append("room_number", self.item.room_number);
      self.data.append("orical_number", self.item.orical_number);
      self.data.append("major_id", self.item.major_id);
      self.data.append("minor_id", self.item.minor_id);
      self.data.append("detaild_id", self.item.detaild_id);

      self.data.append("image", self.item.image);
      axios
        .post("items", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Item");

          this.makeToast(
            "success",
            this.$t("Create.TitleItem"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Item-----------------\
    Update_Item() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("ar_name", self.item.ar_name);
      self.data.append("room_id",  this.$route.params.id);
      self.data.append("category_id", self.item.category_id);
      self.data.append("image", self.item.image);
      self.data.append("purchase_date", self.item.purchase_date);
      self.data.append("status", self.item.status);

      self.data.append("uuid", self.item.uuid);

      self.data.append("room_number", self.item.room_number);
      self.data.append("orical_number", self.item.orical_number);
      self.data.append("major_id", self.item.major_id);
      self.data.append("minor_id", self.item.minor_id);
      self.data.append("detaild_id", self.item.detaild_id);

      self.data.append("_method", "put");

      axios
        .post("items/" + self.item.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Item");

          this.makeToast(
            "success",
            this.$t("Update.TitleItem"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },
  
    //---------------------------------------- Reset Form -----------------\
    reset_Form() {
      this.item = {
        id: "",
        ar_name: "",
        room_id: "",
        category_id: "",
        purchase_date: "",
        uuid: "",
        image: "",
        room_number: "",
        orical_number: "",
        major_id: "",
        minor_id: "",
        detaild_id: "",
 
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Item -----------------\
    Delete_Item(id) {
      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(result => {
        if (result.value) {
          axios
            .delete("items/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleItem"),
                "success"
              );

              Fire.$emit("Delete_Item");
            })
            .catch(() => {
              this.$swal(
                this.$t("Delete.Failed"),
                this.$t("Delete.Therewassomethingwronge"),
                "warning"
              );
            });
        }
      });
    },

    //---- Delete items by selection

    delete_by_selected() {
      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(result => {
        if (result.value) {
          // Start the progress bar.
          NProgress.start();
          NProgress.set(0.1);
          axios
            .post("items/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleItem"),
                "success"
              );

              Fire.$emit("Delete_Item");
            })
            .catch(() => {
              // Complete the animation of theprogress bar.
              setTimeout(() => NProgress.done(), 500);
              this.$swal(
                this.$t("Delete.Failed"),
                this.$t("Delete.Therewassomethingwronge"),
                "warning"
              );
            });
        }
      });
    }
  }, //end Methods
  created: function() {
    this.Get_Items(1);

    Fire.$on("Event_Item", () => {
      setTimeout(() => {
        this.Get_Items(this.serverParams.page);
        this.$bvModal.hide("New_item");
      }, 500);
    });

    Fire.$on("Delete_Item", () => {
      setTimeout(() => {
        this.Get_Items(this.serverParams.page);
      }, 500);
    });
  }
};
</script>