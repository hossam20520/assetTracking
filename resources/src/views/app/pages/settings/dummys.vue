
<template>
  <div class="main-content">
    <breadcumb :page="$t('Dummy')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="dummys"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        @on-search="onSearch"
        :search-options="{
        enabled: true,
        placeholder: $t('Search_this_table'), }"
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
          <!-- <button class="btn btn-danger btn-sm" @click="delete_by_selected()"> {{ $t('Del') }}</button> -->

          <button class="btn btn-primary btn-sm" @click="New_Insert()"> {{ $t('Insert') }}</button>
        </div>



        <div slot="table-actions" class="mt-2 mb-3">
          <b-button @click="New_Dummy()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>


          <b-button
            @click="Show_import_Dummy()"
            size="sm"
            variant="info m-1">
            <i class="i-Download"></i>
            {{ $t("import_dummy") }}
          </b-button>


        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <a @click="Edit_Dummy(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Dummy(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/dummys/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_dummy">
      <b-modal hide-footer size="md" id="New_dummy" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Dummy" enctype="multipart/form-data">
          <b-row>
            <!-- Dummy Name -->



        
                 <b-col md="12" class="mb-2">
                    <validation-provider name="dummy room" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('room')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.room_name"
                          :placeholder="$t('Choose_room')"
                          :reduce="label => label.value"
                          :options="rooms.map(rooms => ({label: rooms.room_name, value: rooms.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
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




    <b-modal hide-footer size="md" id="New_dummy_insert"  title="insertDummy">
        <b-form @submit.prevent="Submit_Dummy" enctype="multipart/form-data">
          <b-row>
     

            <b-col md="12" class="mb-2">
                    <validation-provider name="dummy room" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('locations')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.location_id"
                          :placeholder="$t('Choose_room')"
                          :reduce="label => label.value"
                          v-on:input="handleChange"
                          :options="locations.map(locations => ({label: locations.ar_name, value: locations.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>

                  <b-col md="12" class="mb-2">
                    <validation-provider name="floors" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('floors')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.floor_id"
                          :placeholder="$t('floors')"
                          :reduce="label => label.value"
                          v-on:input="handleChange_floor"
                          :options="floors.map(floors => ({label: floors.ar_name, value: floors.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>



                  <b-col md="12" class="mb-2">
                    <validation-provider name="floors" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('room')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.room_id"
                          :placeholder="$t('room')"
                          :reduce="label => label.value"
                       
                          :options="rooms.map(rooms => ({label: rooms.ar_name, value: rooms.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>




                  <b-col md="12" class="mb-2">
                    <validation-provider name="major_id" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('major_id')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.major_id"
                          :placeholder="$t('major_id')"
                          :reduce="label => label.value"
                       
                          :options="category.map(category => ({label: category.name, value: category.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>

 

                  <b-col md="12" class="mb-2">
                    <validation-provider name="minor_id" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('minor_id')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.minor_id"
                          :placeholder="$t('minor_id')"
                          :reduce="label => label.value"
                       
                          :options="category.map(category => ({label: category.name, value: category.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>



                  <b-col md="12" class="mb-2">
                    <validation-provider name="detaild_id" :rules="{ required: true}">
                      <b-form-group slot-scope="{ valid, errors }" :label="$t('detaild_id')">
                        <v-select
                          :class="{'is-invalid': !!errors.length}"
                          :state="errors[0] ? false : (valid ? true : null)"
                          v-model="dummy.detaild_id"
                          :placeholder="$t('detaild_id')"
                          :reduce="label => label.value"
                       
                          :options="category.map(category => ({label: category.name, value: category.id}))" />
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                  </b-col>

 
                  <!-- rooms -->
            <b-col md="12" class="mt-3">
              <b-button variant="primary" type="submit"   @click="add_data_by_selected"> {{  $t('submit') }}</b-button>
                <div v-once class="typo__p" v-if="SubmitProcessing">
                  <div class="spinner sm spinner-primary mt-3"></div>
                </div>
            </b-col>

          </b-row>
        </b-form>
      </b-modal>


      <b-modal
        ok-only
        ok-title="Cancel"
        size="md"
        id="importDummy"
        :title="$t('import_dummy')"
      >
        <b-form @submit.prevent="Submit_import" enctype="multipart/form-data">
          <b-row>
            <!-- File -->
            <b-col md="12" sm="12" class="mb-3">
              <b-form-group>
                <input type="file" @change="onFileSelecteded" label="Choose File">
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

            <!-- <b-col md="6" sm="12">
              <b-button
                :href="'/import/exemples/import_products.csv'"
                variant="info"
                size="sm"
                block
              >{{ $t("Download_exemple") }}</b-button>
            </b-col> -->

            <b-col md="12" sm="12">
              <table class="table table-bordered table-sm mt-4">
                <tbody>
                  <tr>
                    <td>{{$t('room_name')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>

                   <tr>
                    <td>{{$t('item_name')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                      {{$t('item_name')}}
                    </th>
                  </tr>

                  <tr>
                    <td>{{$t('room_number')}}</td>
                    <th>
                      <span class="badge badge-outline-success">{{$t('Field_is_required')}}</span>
                    </th>
                  </tr>

                  <tr>
                    <td>{{$t('floor')}}</td>
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

export default {
  metaInfo: {
    title: "Dummy"
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
      dummys: [],
      rooms:[],
      floors:[],
      limit: "10",
      locations:[],
      import_products: "",
      category:[],
      dummy: {
        id: "",
        room_id: "",
        location_id: "",
        floor_id: "",
        major_id:0,
        minor_id:0,
        detaild_id:0,
        room_number:"",
      }
    };
  },
  computed: {
    columns() {
      return [
 
        {
          label: this.$t("room_name"),
          field: "room_name",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("item_name"),
          field: "item_name",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("room_number"),
          field: "room_number",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("floor"),
          field: "floor",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("status"),
          field: "status",
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
        this.Get_Dummys(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Dummys(1);
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
      this.Get_Dummys(this.serverParams.page);
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
      this.Get_Dummys(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    
    handleChange_floor(selectedValue){
      this.getRooms(selectedValue);

    },

    handleChange(selectedValue){
      
      this.getLocations(selectedValue);

    },


    onFileSelecteded(e) {
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



    Submit_import() {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      var self = this;
      self.ImportProcessing = true;
      self.data.append("dummys", self.import_products);
      axios
        .post("dummys/import/csv", self.data)
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


    getRooms(selectedValue){

      axios.get( "dropdown/get/room?type=" +  selectedValue  ).then(response => {
      this.rooms = response.data.rooms;
 
 
  })
  .catch(response => {
    // Complete the animation of theprogress bar.
    NProgress.done();
    setTimeout(() => {
      this.isLoading = false;
    }, 500);
  });
    },



    getLocations(selectedValue){
      axios.get( "dropdown/get?type=" +  selectedValue  )
  .then(response => {
    this.floors = response.data.floors;
 
 
  })
  .catch(response => {
    // Complete the animation of theprogress bar.
    NProgress.done();
    setTimeout(() => {
      this.isLoading = false;
    }, 500);
  });
    },
    //------------- Submit Validation Create & Edit Dummy
    Submit_Dummy() {
      this.$refs.Create_dummy.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Dummy();
          } else {
            this.Update_Dummy();
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
        this.dummy.image = e.target.files[0];
      } else {
        this.dummy.image = "";
      }
    },

    //------------------------------ Modal (create Dummy) -------------------------------\
    New_Dummy() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_dummy");
    },


    New_Insert() {
      this.reset_Form();
      // this.editmode = false;
      this.$bvModal.show("New_dummy_insert");
    },


    //------------------------------ Modal (Update Dummy) -------------------------------\
    Edit_Dummy(dummy) {
      this.Get_Dummys(this.serverParams.page);
      this.reset_Form();
      this.dummy = dummy;
      this.editmode = true;
      this.$bvModal.show("New_dummy");
    },

    //---------------------------------------- Get All dummys-----------------\
    Get_Dummys(page) {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "dummys?page=" +
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
          this.dummys = response.data.dummys;
          this.totalRows = response.data.totalRows;
          this.locations = response.data.locations;
          this.category = response.data.category;
          // this.rooms = response.data.rooms;
          // console.log(response.data.rooms)
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

    //---------------------------------------- Create new dummy-----------------\
    Create_Dummy() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("room_name", self.dummy.room_name);
      // self.data.append("en_name", self.dummy.en_name);
      // self.data.append("image", self.dummy.image);
      axios
        .post("dummys", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Dummy");

          this.makeToast(
            "success",
            this.$t("Create.TitleDummy"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Dummy-----------------\
    Update_Dummy() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("room_name", self.dummy.room_name);
      // self.data.append("ar_name", self.dummy.ar_name);
      // self.data.append("image", self.dummy.image);
      self.data.append("_method", "put");

      axios
        .post("dummys/" + self.dummy.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Dummy");

          this.makeToast(
            "success",
            this.$t("Update.TitleDummy"),
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
      this.dummy = {
        id: "",
        ar_name: "",
        en_name: "",
        image: ""
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Dummy -----------------\
    Delete_Dummy(id) {
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
            .delete("dummys/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleDummy"),
                "success"
              );

              Fire.$emit("Delete_Dummy");
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

    Show_import_Dummy() {
      this.$bvModal.show("importDummy");
    },


    Insert_by_selected(){
      this.$bvModal.show("New_dummy");
    },


    add_data_by_selected() {
 
        this.$swal({
        title: this.$t("InsertData"),
        text: this.$t("InsertData"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("cancel"),
        confirmButtonText: this.$t("confirm")
      }).then(result => {
        if (result.value) {
          // Start the progress bar.
          NProgress.start();
          NProgress.set(0.1);
          axios.post("dummys/insert/by_selection", {
              selectedIds: this.selectedIds ,

        room_id:this.dummy.room_id,
        location_id:this.dummy.location_id,
        floor_id:this.dummy.floor_id,
        major_id:this.dummy.major_id,
        minor_id:this.dummy.minor_id,
        detaild_id:this.dummy.detaild_id,
        room_number:this.dummy.room_number,
              
            })
            .then(() => {
              this.$swal(
                this.$t("Success"),
                this.$t("Success"),
                "success"
              );

              Fire.$emit("Delete_Dummy");
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





    },

    //---- Delete dummys by selection

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
          axios.post("dummys/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleDummy"),
                "success"
              );

              Fire.$emit("Delete_Dummy");
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
    this.Get_Dummys(1);

    Fire.$on("Event_Dummy", () => {
      setTimeout(() => {
        this.Get_Dummys(this.serverParams.page);
        this.$bvModal.hide("New_dummy");
      }, 500);
    });

    Fire.$on("Delete_Dummy", () => {
      setTimeout(() => {
        this.Get_Dummys(this.serverParams.page);
      }, 500);
    });


    // Fire.$on("Event_import", () => {
    //   setTimeout(() => {
    //     this.Get_Products(this.serverParams.page);
    //     this.$bvModal.hide("importProducts");
    //   }, 500);
    // });


  }
};
</script>