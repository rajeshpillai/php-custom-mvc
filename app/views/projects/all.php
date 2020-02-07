<h2>All Projects</h2>

<div>
<a href="add">Add New Project</a>
</div>

<div id="all_projects">
<?php
    View::grid($this->model)
?>
</div>
<div>
<a href="add">Add New Project</a>
</div>

<script type="text/javascript">
    /*
    $(function() {
        //$("table.grid").kendoGrid();
        $("table.grid").kendoGrid({
         scrollable: {
             virtual: true
         }
      });
        
    });
    */
</script>