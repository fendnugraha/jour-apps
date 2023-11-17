</div>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!-- <script src="/assets/js/bootstrap.js"></script> -->
<!-- <script src="/assets/js/datatables.min.js"></script> -->
<!-- <script src="/assets/js/popper.min.js"></script> -->
<script src="/assets/js/jquery-3.5.1.js"></script>
<script src="/assets/js/jquery-ui.js"></script>
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/js/all.min.js"></script>
<script src="/assets/js/fontawesome.min.js"></script>
<script src="/assets/js/myjs.js"></script>
<script>
    $(document).ready(function() {
        $('table.display').DataTable();
        $('table.display-noorder').DataTable({
            "ordering": false,
            // "paging": false
        });
    });

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true
        }).val();
    });
</script>
</body>

</html>