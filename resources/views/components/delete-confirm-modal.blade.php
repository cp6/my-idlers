<div v-if="showModal">
        <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header py-1">
                            <h4 class="modal-title" id="modal-title" v-html="modal_hostname"></h4>
                        </div>
                        <div class="modal-body text-center">
                            Are you sure you want to delete this?
                            <form :action=delete_form_action method="POST">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" id="id" name="id" value="" v-model="modal_id">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="submit" title="delete"
                                                class="btn btn-danger px-3 py-1 mt-2 mt-2">
                                            Yes
                                        </button>
                                    </div>
                                    <div class="col-6">

                                        <button type="submit" title="delete"
                                                class="btn btn-success px-3 py-1 mt-2 ms-4" @click="showModal=false">
                                            No
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</div>
