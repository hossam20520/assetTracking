
<template>
  <div class="main-content">
    <breadcumb :page="$t('Room')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="rooms"
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
          <b-button @click="New_Room()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            

            <!-- <a @click="PrintData(props.row)" title="print" v-b-tooltip.hover>
              <i class="i-Paper text-25 text-success"></i>
            </a> -->
            <router-link
              v-b-tooltip.hover
              title="print"
              :to="{ name:'barcode', params: { id: props.row.id} }">
              <i class="i-Paper text-25 text-info"></i>
            </router-link>



            <router-link
              v-b-tooltip.hover
              title="View"
              :to="{ name:'detail_Item', params: { id: props.row.id} }">
              <i class="i-Eye text-25 text-info"></i>
            </router-link>


            <a @click="Edit_Room(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Room(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>



            <router-link
              v-b-tooltip.hover
              title="print"
              :to="{ name:'oneBarcode', params: { id: props.row.id ,    type: 'room' } }">
              <i class="i-QR-Code text-25 text-info"></i>
            </router-link>


          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/rooms/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_room">
      <b-modal hide-footer size="md" id="New_room" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Room" enctype="multipart/form-data">
          <b-row>
            <!-- Room Name -->



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
                        v-model="room.ar_name"
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
                        label="room_number"
                        :placeholder="$t('room_number')"
                        v-model="room.room_number"
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
                        v-model="room.uuid"
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
    title: "Room"
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
      rooms: [],
      limit: "10",
      room: {
        id: "",
        uuid:"",
        room_number:"",
        ar_name: "",
        build_id: "",
       
      }
    };
  },
  computed: {
    columns() {
      return [
      {
          label: this.$t("id"),
          field: "id",
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
          label: this.$t("uuid"),
          field: "uuid",
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
        this.Get_Rooms(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Rooms(1);
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
      this.Get_Rooms(this.serverParams.page);
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
      this.Get_Rooms(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Room
    Submit_Room() {
      this.$refs.Create_room.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Room();
          } else {
            this.Update_Room();
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

    PrintData(obj){

      console.log(obj.id);
    },

    //------------------------------ Event Upload Image -------------------------------\
    async onFileSelected(e) {
      const { valid } = await this.$refs.Image.validate(e);

      if (valid) {
        this.room.image = e.target.files[0];
      } else {
        this.room.image = "";
      }
    },

    //------------------------------ Modal (create Room) -------------------------------\
    New_Room() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_room");
    },

    //------------------------------ Modal (Update Room) -------------------------------\
    Edit_Room(room) {
      this.Get_Rooms(this.serverParams.page);
      this.reset_Form();
      this.room = room;
      this.editmode = true;
      this.$bvModal.show("New_room");
    },

    //---------------------------------------- Get All rooms-----------------\
    Get_Rooms(page) {
      // Start the progress bar.
      let id =  this.$route.params.id;
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "rooms?page=" +
            page +
            "&SortField=" +
            this.serverParams.sort.field +
            "&SortType=" +
            this.serverParams.sort.type +
            "&id="+
             id +
            "&search=" +
            this.search +
            "&limit=" +
            this.limit
        )
        .then(response => {
          this.rooms = response.data.rooms;
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

    //---------------------------------------- Create new room-----------------\
    Create_Room() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("ar_name", self.room.ar_name);
      self.data.append("uuid", self.room.uuid);
      self.data.append("build_id", this.$route.params.id);
      self.data.append("room_number", self.room.room_number);
      
      axios
        .post("rooms", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Room");

          this.makeToast(
            "success",
            this.$t("Create.TitleRoom"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Room-----------------\
    Update_Room() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("ar_name", self.room.ar_name);
      self.data.append("build_id", this.$route.params.id);
      self.data.append("uuid", self.room.uuid);
      self.data.append("room_number", self.room.room_number);
      self.data.append("_method", "put");

      axios
        .post("rooms/" + self.room.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Room");

          this.makeToast(
            "success",
            this.$t("Update.TitleRoom"),
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
      this.room = {
        id: "",
        ar_name: "",
        uuid:"",
        room_number:"",
        build_id: ""
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Room -----------------\
    Delete_Room(id) {
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
            .delete("rooms/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleRoom"),
                "success"
              );

              Fire.$emit("Delete_Room");
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

    //---- Delete rooms by selection

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
            .post("rooms/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleRoom"),
                "success"
              );

              Fire.$emit("Delete_Room");
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
    this.Get_Rooms(1);

    Fire.$on("Event_Room", () => {
      setTimeout(() => {
        this.Get_Rooms(this.serverParams.page);
        this.$bvModal.hide("New_room");
      }, 500);
    });

    Fire.$on("Delete_Room", () => {
      setTimeout(() => {
        this.Get_Rooms(this.serverParams.page);
      }, 500);
    });
  }
};
</script>