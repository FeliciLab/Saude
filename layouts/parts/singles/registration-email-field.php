<div class="registration-fieldset">
    <div style="padding-bottom: 10px">
        <span class="js-editable"
            id="draftEmailCheck"
            data-edit="draftEmailCheck">
                <?php echo $entity->draftEmailCheck ?>
        </span>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#draftEmailCheck').editable('setValue', 0);
    });
</script>