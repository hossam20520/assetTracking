
<template>
  <div class="main-content">
    <breadcumb :page="$t('Inventore')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="inventores"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        @on-search="onSearch"
        :search-options="{
        enabled: false,
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
 
     

        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <!-- <a @click="Edit_Inventore(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a> -->
            <!-- <a title="Delete" v-b-tooltip.hover @click="Delete_Inventore(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a> -->


            <!-- <router-link
              v-b-tooltip.hover
              title="detail"
              :to="{ name:'inventorilist', params: { id: props.row.id  } }">
              <i class="i-Pen-3 text-25 text-info"></i>
            </router-link> -->
          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/inventores/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_inventore">
      <b-modal hide-footer size="md" id="New_inventore" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Inventore" enctype="multipart/form-data">
          <b-row>
            <!-- Inventore Name -->



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
                        v-model="inventore.ar_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>

            <!-- Inventore -->
            <b-col md="12">
              <validation-provider
                    name="en_Name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('Name_en_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="en_name"
                        :placeholder="$t('Enter_Name_en_name')"
                        v-model="inventore.en_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>

            <!-- -Inventore Image -->
            <b-col md="12">
              <validation-provider name="Image" ref="Image" rules="mimes:image/*">
                <b-form-group slot-scope="{validate, valid, errors }" :label="$t('InventoreImage')">
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
  </div>
</template>

<script>
import NProgress from "nprogress";

export default {
  metaInfo: {
    title: "Inventore"
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
      inventores: [],
      limit: "10",
      inventore: {
        id: "",
        ar_name: "",
        en_name: "",
        image: ""
      }
    };
  },
  computed: {
    columns() {
      return [
    
        {
          label: this.$t("item_status"),
          field: "item_status",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("item"),
          field: "item",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("barcode"),
          field: "uuid",
          tdClass: "text-left",
          thClass: "text-left"
        },

   
        // {
        //   label: this.$t("location"),
        //   field: "location",
        //   tdClass: "text-left",
        //   thClass: "text-left"
        // },


        // {
        //   label: this.$t("room"),
        //   field: "room",
        //   tdClass: "text-left",
        //   thClass: "text-left"
        // },


        // {
        //   label: this.$t("floor"),
        //   field: "floor",
        //   tdClass: "text-left",
        //   thClass: "text-left"
        // },
        
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
    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Inventores(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Inventores(1);
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
      this.Get_Inventores(this.serverParams.page);
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
      this.Get_Inventores(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Inventore
    Submit_Inventore() {
      this.$refs.Create_inventore.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Inventore();
          } else {
            this.Update_Inventore();
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
        this.inventore.image = e.target.files[0];
      } else {
        this.inventore.image = "";
      }
    },

    //------------------------------ Modal (create Inventore) -------------------------------\
    New_Inventore() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_inventore");
    },

    //------------------------------ Modal (Update Inventore) -------------------------------\
    Edit_Inventore(inventore) {
      this.Get_Inventores(this.serverParams.page);
      this.reset_Form();
      this.inventore = inventore;
      this.editmode = true;
      this.$bvModal.show("New_inventore");
    },

    //---------------------------------------- Get All inventores-----------------\
    Get_Inventores(page) {
      // Start the progress bar.
      let id = this.$route.params.id;
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "inventores/data/"+ id +"/?page=" +
            page +
            "&SortField=" +
            this.serverParams.sort.field +
            "&SortType=" +
            this.serverParams.sort.type +
            "&search=" +
            this.search +
            "&limit=" +
            this.limit
        )
        .then(response => {
          
          this.inventores = response.data.inventories;

          this.totalRows = response.data.totalRows;

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

    //---------------------------------------- Create new inventore-----------------\
    Create_Inventore() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("ar_name", self.inventore.ar_name);
      self.data.append("en_name", self.inventore.en_name);
      self.data.append("image", self.inventore.image);
      axios
        .post("inventores", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Inventore");

          this.makeToast(
            "success",
            this.$t("Create.TitleInventore"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Inventore-----------------\
    Update_Inventore() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("en_name", self.inventore.en_name);
      self.data.append("ar_name", self.inventore.ar_name);
      self.data.append("image", self.inventore.image);
      self.data.append("_method", "put");

      axios
        .post("data/inventores/" + self.inventore.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Inventore");

          this.makeToast(
            "success",
            this.$t("Update.TitleInventore"),
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
      this.inventore = {
        id: "",
        ar_name: "",
        en_name: "",
        image: ""
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Inventore -----------------\
    Delete_Inventore(id) {
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
            .delete("inventores/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleInventore"),
                "success"
              );

              Fire.$emit("Delete_Inventore");
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

    //---- Delete inventores by selection

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
            .post("inventores/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleInventore"),
                "success"
              );

              Fire.$emit("Delete_Inventore");
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
    this.Get_Inventores(1);

    Fire.$on("Event_Inventore", () => {
      setTimeout(() => {
        this.Get_Inventores(this.serverParams.page);
        this.$bvModal.hide("New_inventore");
      }, 500);
    });

    Fire.$on("Delete_Inventore", () => {
      setTimeout(() => {
        this.Get_Inventores(this.serverParams.page);
      }, 500);
    });
  }
};
</script>