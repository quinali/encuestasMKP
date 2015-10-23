<script type="text/javascript">
    
    function hideFieldRecharge(){
                
                fieldContent="[";
                $("#lstBox2 > option").each(function() {
                    fieldContent+="\""+this.value+"\",";
            });
            
            fieldContent+=']';
            fieldContent=fieldContent.replace(",]","]");

            $('input#operadoresID').val(fieldContent);
                
                
    }

            $('#btnRight').click(function(e) {

                var selectedOpts = $('#lstBox1 option:selected');
                if (selectedOpts.length == 0) {
                    alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox2').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
                hideFieldRecharge();
            });

            $('#btnLeft').click(function(e) {
                var selectedOpts = $('#lstBox2 option:selected');
                if (selectedOpts.length == 0) {
                    //alert("Nothing to move.");
                    e.preventDefault();
                }

                $('#lstBox1').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
                hideFieldRecharge();
            });
    
</script>
