<script id="option-aub-template" type="text/template">

    <div class="control-group" <% if(last) { %>style="border-bottom:1px solid #eee;padding-bottom:5px;"<% } %>>
        <div class="inopts">
            <% if(first) { %><label class="control-label" for="inputpayment">Amount :</label><% } %>
            <div class="controls">
                <input type="text" id="inputpayment" class="currency" value="<%= (payment)? payment : 0 %>" name="payment" style="width: 20%;"/>
                <input type="text" id="inputstatus" placeholder="Remarks" value="<%= (status)? status : ''  %>" name="status" style="width: 35%;"/>
                <input type="text" class="ddate" value="<%= (dt)? dt : '' %>" name="date_terms" style="width: 20%;"/>
                <label class="checkbox inline" style="vertical-align:top">
                    <input type="checkbox" name="ispaid" value="1" /> Paid
                </label>   
                <% if (last) { %>
                    <div class="clearfix"></div>
                    <p class="help-inline"><a class="add-new" href="#" rel="AUB"><small>Add another Terms</small></a></p>
                <% } %>                                      
            </div> 
        </div>
    </div>
</script>

<!-- Modal Add -->          
<div class="modal hide fade" id="editaub" style="width: 600px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Terms Payment <small>&raquo; Setup</small></h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div id="container-option-aub"></div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-success" id="aub-submit">Submit</a>
    </div>
</div>
<!-- End Add -->
