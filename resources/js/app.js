import "./bootstrap";
import Alpine from "alpinejs";
import Chart from "chart.js/auto";

// Initialize Alpine.js — pastikan DOM sudah tersedia sebelum Alpine.start()
window.Alpine = Alpine;

// Gunakan DOMContentLoaded sebagai safety net agar Alpine menemukan semua elemen x-data
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => Alpine.start());
} else {
    // DOM sudah siap (bisa terjadi jika script di-cache)
    Alpine.start();
}

/**
 * Fungsi global untuk memicu confirm modal.
 * Tidak bergantung pada Alpine scope — dispatch langsung ke window.
 *
 * @param {Object} detail - { title, message, actionUrl, method, type, confirmText }
 */
window.confirmAction = function (detail) {
    window.dispatchEvent(
        new CustomEvent("confirm-action", {
            detail: detail,
            bubbles: true,
        }),
    );
};

// Make Chart.js globally available
window.Chart = Chart;

// Custom helper functions
window.formatCurrency = function (amount) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
};

window.formatNumber = function (num) {
    return new Intl.NumberFormat("id-ID").format(num);
};

// Global notification function
window.showNotification = function (message, type = "success") {
    const notification = document.createElement("div");
    const bgColor =
        {
            success: "bg-green-500",
            error: "bg-red-500",
            warning: "bg-yellow-500",
            info: "bg-blue-500",
        }[type] || "bg-gray-500";

    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${bgColor} shadow-lg transform transition-all duration-300 translate-x-full`;
    notification.textContent = message;
    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove("translate-x-full");
    }, 100);

    // Animate out and remove
    setTimeout(() => {
        notification.classList.add("translate-x-full");
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// Loading overlay helper
window.showLoading = function (show = true) {
    let overlay = document.getElementById("loading-overlay");

    if (show) {
        if (!overlay) {
            overlay = document.createElement("div");
            overlay.id = "loading-overlay";
            overlay.className =
                "fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center";
            overlay.innerHTML = `
                <div class="bg-white rounded-xl p-8 shadow-2xl flex flex-col items-center gap-4">
                    <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <span class="text-gray-600 font-medium">Memuat...</span>
                </div>
            `;
            document.body.appendChild(overlay);
        }
        overlay.classList.remove("hidden");
    } else if (overlay) {
        overlay.classList.add("hidden");
    }
};
