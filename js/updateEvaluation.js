
$(document).ready(function() {
    // Handle individual evaluation update
    $(document).on('click', '.update-evaluation-btn', function() {
        var evaluationId = $(this).data('id');

        // Get the updated values from the input fields
        var evaluationDate = $("input[name='evaluation_date_" + evaluationId + "']").val();
        var remarks = $("input[name='remarks_" + evaluationId + "']").val();
        var evaluatorName = $("input[name='evaluator_name_" + evaluationId + "']").val();

        // AJAX request to update the evaluation record
        $.ajax({
            url: 'productionSchedulingAndControl/update_evaluation.php', // This file will handle the update logic
            method: 'POST',
            data: {
                evaluation_id: evaluationId,
                evaluation_date: evaluationDate,
                remarks: remarks,
                evaluator_name: evaluatorName
            },
            success: function(response) {
                // Show snackbar on success
                var snackbar = $("#snackbar");
                snackbar.text('Evaluation updated successfully!');
                snackbar.addClass("show");
                setTimeout(function() { snackbar.removeClass("show"); }, 3000); // Hide after 3 seconds
            },
            error: function(xhr, status, error) {
                // Show snackbar on error
                var snackbar = $("#snackbar");
                snackbar.text('Error: ' + error);
                snackbar.addClass("show");
                setTimeout(function() { snackbar.removeClass("show"); }, 3000); // Hide after 3 seconds
            }
        });
    });
});