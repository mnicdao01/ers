
            <table class="table table-bordered" id="table_attendance">
                <thead>
                <tr>
                     <th>ID</th>
                    <th>USERNAME</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>LOGGED IN</th>
                    <th>LOGGED OUT</th>
                    <th>TOTAL HOURS</th>


                </tr>
                </thead>
                <tbody>

                <?php foreach($results as $row){?>
                    <tr>
                        <td><?php echo $row->id?></td>
                        <td><?php echo $row->username?></td>
                        <td><?php echo $row->fname?></td>
                        <td><?php echo $row->lname?></td>
                        <td><?php echo $row->timein?></td>
                        <td><?php echo $row->timeout?></td>
                        <td><?php echo $row->SubTotal?></td>




                    </tr>
                <?php } ?>
                </tbody>

            </table>

<script>
  $(document).ready(function(){

      var global_level = $('#global_level').val();

      if(global_level == '2' || global_level == '1' || global_level == '5'){
          $('#btnEditTimein').show();
          $('#btnDeleteTimein').show();
          $('#btnEditTimein').on('click', function(data){

              var id = table.cell('.selected',0).data();
              var timein = table.cell('.selected',4).data();
              var timeout = table.cell('.selected',5).data();

              if(id != ''){
                  $('#myModal').modal('show');
                  $.post('main/load_edit_timein',{id:id,timein: timein, timeout: timeout}, function(data){
                      $('#modal_body').html(data);


                  });
              }
              else{
                  alertify.alert('Please select data to fix.')
              }
          });
      }else{
          $('#btnEditTimein').hide();
      }
      var table = $('#table_attendance').DataTable({
          "bSort": false

      });

      $('#table_attendance tbody').on( 'click', 'tr', function () {

          if ( $(this).hasClass('selected') ) {

              $(this).removeClass('selected');
          }
          else {
              table.$('tr.selected').removeClass('selected');
              $(this).addClass('selected');
          }
      } );

      $('#btnDeleteTimein').on('click', function(){

          alertify.confirm('Are you sure you want to delete?').set('onok', function(closeEvent){
              var id = table.cell('.selected',0).data();



              table.row('.selected').remove().draw( false );

              $.post('main/delete_timein', {id: id}, function (data){

                  alertify.success(data);
              })
          });

      })


  })

</script>