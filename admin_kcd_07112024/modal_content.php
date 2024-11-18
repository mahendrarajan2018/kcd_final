<button type="button" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="d-none delete_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title h5">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Are you sure want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success no" onClick="Javascript:cancel_delete_modal(this);" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger yes" onClick="Javascript:confirm_delete_modal(this);" >Delete</button>
            </div>
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#CancelBillModal" class="d-none cancel_bill_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CancelBillModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <form name="bill_cancel_form" method="post">  
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name="cancel_bill_id" value="">      
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group mb-0">
                                <label class="form-control-label">Remarks</label>
                                <div class="w-100">
                                    <textarea name="cancel_bill_remarks" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success submit_button" onClick="Javascript:ConfirmCancelBill();">Confirm</button>
                        </div>
                    </div>
                </div>
            </form>
        
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#AcknowledgementModal" class="d-none acknowledgement_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="AcknowledgementModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Invocie Acknowledgement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>
<button type="button" data-bs-toggle="modal" data-bs-target="#clearancemodal" class="d-none clearance_modal_button"></button>
<div class="modal fade" id="clearancemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title h5">Parcel Receiving Person Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>