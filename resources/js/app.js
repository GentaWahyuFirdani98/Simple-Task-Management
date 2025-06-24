import './bootstrap';

// Task status update functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle status change via select dropdown
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            const newStatus = this.value;
            
            updateTaskStatus(taskId, newStatus);
        });
    });
    
    // Handle delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-task');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this task?')) {
                e.preventDefault();
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Function to update task status via AJAX
function updateTaskStatus(taskId, status) {
    fetch(`/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the status badge
            const statusBadge = document.querySelector(`#status-badge-${taskId}`);
            if (statusBadge) {
                statusBadge.className = `status-${status}`;
                statusBadge.textContent = status.replace('_', ' ').toUpperCase();
            }
            
            // Show success message
            showAlert('Status updated successfully!', 'success');
        } else {
            showAlert('Failed to update status!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred!', 'error');
    });
}

// Function to show alert messages
function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    if (!alertContainer) return;
    
    const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    
    const alertHTML = `
        <div class="alert border-l-4 p-4 mb-4 ${alertClass}">
            <p>${message}</p>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    
    // Auto-hide after 3 seconds
    setTimeout(() => {
        const newAlert = alertContainer.lastElementChild;
        if (newAlert) {
            newAlert.style.opacity = '0';
            setTimeout(() => {
                newAlert.remove();
            }, 300);
        }
    }, 3000);
}
