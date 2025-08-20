<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <span id="currentYear"></span>
                © 
                <script>
                    document.getElementById("currentYear").textContent = new Date().getFullYear();
                </script>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Thiết kế và phát triển bởi Lập trình viên
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("currentYear").textContent = new Date().getFullYear();
    </script>
</footer>