
<template>
  <div class="main-content">
    <breadcumb :page="$t('floor')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="builds"
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
          <b-button @click="New_Build()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">

            <router-link
              v-b-tooltip.hover
              title="View"
              :to="{ name:'detail_room', params: { id: props.row.id} }">
              <i class="i-Eye text-25 text-info"></i>
            </router-link>
 

            <a @click="Edit_Build(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Build(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/builds/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_build">
      <b-modal hide-footer size="md" id="New_build" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Build" enctype="multipart/form-data">
          <b-row>
            <!-- Build Name -->



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
                        v-model="build.ar_name"
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
                        v-model="build.uuid"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
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
    title: "Build"
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
      builds: [],
      limit: "10",
      build: {
        id: "",
        ar_name: "",
        uuid:"",
        location_id : this.$route.params.id,
 
      }
    };
  },
  computed: {
    columns() {
      return [
 
        {
          label: this.$t("BuildName"),
          field: "ar_name",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("uuid"),
          field: "uuid",
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
    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Builds(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Builds(1);
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
      this.Get_Builds(this.serverParams.page);
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
      this.Get_Builds(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Build
    Submit_Build() {
      this.$refs.Create_build.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Build();
          } else {
            this.Update_Build();
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
        this.build.image = e.target.files[0];
      } else {
        this.build.image = "";
      }
    },

    //------------------------------ Modal (create Build) -------------------------------\
    New_Build() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_build");
    },

    //------------------------------ Modal (Update Build) -------------------------------\
    Edit_Build(build) {
      this.Get_Builds(this.serverParams.page);
      this.reset_Form();
      this.build = build;
      this.editmode = true;
      this.$bvModal.show("New_build");
    },

    //---------------------------------------- Get All builds-----------------\
    Get_Builds(page) {
      // Start the progress bar.
      let id = this.$route.params.id
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "builds?page=" +
            page +
            "&SortField=" +
            this.serverParams.sort.field +
            "&id=" +
             id +
            "&SortType=" +
            this.serverParams.sort.type +
            "&search=" +
            this.search +
            "&limit=" +
            this.limit
        )
        .then(response => {
          this.builds = response.data.builds;
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

    //---------------------------------------- Create new build-----------------\
    Create_Build() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("ar_name", self.build.ar_name);
      self.data.append("uuid", self.build.uuid);
      self.data.append("location_id", this.$route.params.id);
      axios
        .post("builds", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Build");

          this.makeToast(
            "success",
            this.$t("Create.TitleBuild"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Build-----------------\
    Update_Build() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("ar_name", self.build.ar_name);
      self.data.append("location_id", this.$route.params.id);
      self.data.append("uuid", self.build.uuid);
      self.data.append("_method", "put");

      axios
        .post("builds/" + self.build.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Build");

          this.makeToast(
            "success",
            this.$t("Update.TitleBuild"),
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
      this.build = {
        id: "",
        ar_name: "",
        location_id: "",
        uuid:"",
      
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Build -----------------\
    Delete_Build(id) {
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
            .delete("builds/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleBuild"),
                "success"
              );

              Fire.$emit("Delete_Build");
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

    //---- Delete builds by selection

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
            .post("builds/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleBuild"),
                "success"
              );

              Fire.$emit("Delete_Build");
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
    this.Get_Builds(1);

    Fire.$on("Event_Build", () => {
      setTimeout(() => {
        this.Get_Builds(this.serverParams.page);
        this.$bvModal.hide("New_build");
      }, 500);
    });

    Fire.$on("Delete_Build", () => {
      setTimeout(() => {
        this.Get_Builds(this.serverParams.page);
      }, 500);
    });
  }
};
</script>