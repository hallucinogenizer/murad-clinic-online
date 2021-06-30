<!--modal starts-->


<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <select id='deleteSelector' class='hidden'><option>Hello</option><?php echo $typestext;  ?></select>
        <div id='multiDatePicker' class='hidden'>
          <p>Choose the starting date and ending date of your range. You will be shown combined statistics for all the days that lie within that range.</p>
        <label for='from'>From:</label><input type='date' name='from' class='from'><br>
        <label for='to'>To:</label><input type='date' name='to' class='to'>
      </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id='continue' class='hidden'>Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id='closeButton'>Close</button>
      </div>

    </div>
  </div>
</div>

<!--modal ends-->
