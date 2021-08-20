<template>
    <div class="card">
        <div class="card-header border-bottom p-1">
            <div class="head-label">
                <h2 class="mb-0">Sales</h2>
            </div>
        </div>
        <div class="card-body">
            <!-- Per Page Area -->
            <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                <div class="col-md-4" style="margin-left: inherit;">
                    <b-form-group
                    label="Per page"
                    label-for="per-page-select"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    >
                    <b-form-select
                        id="per-page-select"
                        v-model="perPage"
                        :options="pageOptions"
                        size="sm"
                    ></b-form-select>
                    </b-form-group>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-left: inherit;">
                    <b-form-group
                    label="Filter"
                    label-for="filter-input"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    >
                    <b-input-group size="sm">
                        <b-form-input
                        id="filter-input"
                        v-model="filter"
                        type="search"
                        placeholder="Type to Search"
                        ></b-form-input>

                        <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                    </b-form-group>
                </div>
            </div>

            <!-- Main table element -->
            <b-table
                id="sales-table"
                striped
                :items="sales"
                :busy="isLoading"
                :fields="fields"
                :filter="filter"
                :current-page="currentPage"
                :per-page="perPage"
                sort-icon-left
                responsive="sm"
                :tbody-transition-props="transProps"
                show-empty
                primary-key="id"
            >
                <template #table-busy>
                    <div class="text-center my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>

                <template #cell(name)="row">
                    <div v-if="row.item.name">
                        <a href="#" data-toggle="tooltip" @click="edit(row.item)" title="Edit Account">{{ row.item.name }}</a>
                    </div>
                </template>

                <template #cell(actions)="row">
                    <b-button variant="danger" size="sm" @click="sendInfo(row.item.id)" data-toggle="modal" data-target="#delete-bank-account" class="mr-1">
                        Delete
                    </b-button>
                    <b-button variant="primary" size="sm" @click="row.toggleDetails">
                        {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
                    </b-button>
                </template>

                <template #row-details="row">
                    <b-card>
                        <ul>
                            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                        </ul>
                    </b-card>
                </template>
            </b-table>

            <!-- Delete Modal -->
            <div class="modal fade text-center" id="delete-bank-account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1">Delete Sale</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Sale</h3>
                                <p>Are you sure want to delete?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <b-button variant="primary" :disabled="disableDeleteButton" @click="destroy(selected_account_id)" type="button" value="Delete">
                                {{deleting ? "Deleting..." : "Delete"}}
                                <b-spinner v-if="deleting" small type="grow"></b-spinner>
                            </b-button>
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-between mx-0" style="margin-top: 15px; margin-bottom: 15px;">
                <div class="col-md-12">
                    <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    size="sm"
                    class="my-0 justify-content-center"
                    ></b-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
export default {

    data() {
        return {
            sales: [],
            fields: [
                { key: 'id', label: 'ID.', sortable: true, sortDirection: 'desc' },
                { key: 'product_name', label: 'Product Name', sortable: true, sortDirection: 'acs' },
                { key: 'date', label: 'Date', sortable: true, sortDirection: 'acs' },
                { key: 'sales_person', label: 'Sales Person', sortable: true, sortDirection: 'acs' },
                { key: 'customer_name', label: 'Customer Name', sortable: true },
                { key: 'registered_at', label: 'Registered', class: 'text-center' },
                { key: 'actions', label: 'Actions', class: 'text-center' }
            ],
            transProps: {
                // Transition name
                name: 'flip-list'
            },
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
            sortBy: '',
            sortDesc: false,
            filter: null,
            sortDirection: 'asc',
            selected_account_id: '',
            isLoading: false,
            deleting: false,
            errors: null,
            notificationSystem: {
            options: {
                success: {
                    position: "center",
                    timeout: 3000,
                    class: 'success_notification'
                },
                error: {
                    overlay: true,
                    zindex: 999,
                    position: "center",
                    timeout: 3000,
                    class: 'error_notification'
                },
                completed: {
                    position: 'center',
                    timeout: 1000,
                    class: 'complete_notification'
                },
                info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    class: 'info_notification',
                }
            }
            },
        };
    },
    created() {
        var _this = this;
        this.get_sales();
        EventBus.$on("bank-account-added", function() {
            _this.get_sales();
        });
    },

    mounted() {
        
    },

    methods: {
        get_sales() {
            this.isLoading = true;
            axios
                .get(
                base_url +
                    "data-grid/sales-list"
                )
                .then(response => {
                    this.sales = response.data
                    // Set the initial number of items
                    this.totalRows = this.sales.length
                    this.isLoading = false;
                })
                .catch(err => {
                if (err.response) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        showMessage(data) {
            if (data.status  == "success") {
                this.$toast.success(data.message, 'Success Alert', this.notificationSystem.options.info );
            } else {
                this.$toast.error(data.message, "Error Alert", this.notificationSystem.options.error);
            }
        },

        edit(item) {
            EventBus.$emit("edit-bank-account", item.id);
        },

        info(item, index, button) {
            this.infoModal.title = `Row index: ${index}`
            this.infoModal.content = JSON.stringify(item, null, 2)
            this.$root.$emit('bv::show::modal', this.infoModal.id, button)
        },
        resetInfoModal() {
            this.infoModal.title = ''
            this.infoModal.content = ''
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },

        sendInfo(id) {
            this.selected_account_id = id;
        },

        destroy(id) {
            this.deleting = true
            axios.delete(base_url + "data-grid/sale/" + id)

            .then(response => {
                this.deleting = false
                $("#delete-bank-account .close").click()
                EventBus.$emit("bank-account-added");
                this.showMessage(response.data);
            })
            .catch(err => {
                if (err.response) {
                    this.deleting = false
                    this.showMessage(err.response.data)
                }
            });
            
        }
    },

    computed: {
        show() {
            return this.sales ? (this.sales.length >= 1 ? true: false) : null
        },

        sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      },

      disableDeleteButton() {
            return this.deleting ? true: false
        }
    }
}
</script>

<style scoped>
    table#table-transition-example .flip-list-move {
        transition: transform 1s;
    }
</style>