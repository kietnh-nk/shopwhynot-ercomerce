(function () {
    "use strict";

    class LinLicenseManager {
        constructor() {
            this.licenseKey = "LIN_2025_REACT_LICENSE";
            this.expiryDate = "2025-09-27";
            this.isActivated = true;
            this.storageKey = "lin_license_data";

            this.autoInit();
        }

        autoInit() {
            this.setupAutoCheck();

            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", () => {
                    this.setupEventListeners();
                });
            } else {
                this.setupEventListeners();
            }
        }

        setupAutoCheck() {
            // Kiểm tra license ngay lập tức
            try {
                this.validateOrThrow();
            } catch (error) {
                this.showBlankPage();
                return;
            }

            // Kiểm tra định kỳ mỗi 30 giây
            setInterval(() => {
                try {
                    this.validateOrThrow();
                } catch (error) {
                    this.showBlankPage();
                }
            }, 30000);
        }

        setupEventListeners() {
            // Kiểm tra khi window focus
            window.addEventListener("focus", () => {
                try {
                    this.validateOrThrow();
                } catch (error) {
                    this.showBlankPage();
                }
            });

            // Kiểm tra khi visibility change
            document.addEventListener("visibilitychange", () => {
                if (!document.hidden) {
                    try {
                        this.validateOrThrow();
                    } catch (error) {
                        this.showBlankPage();
                    }
                }
            });

            // Kiểm tra khi có bất kỳ click nào
            document.addEventListener("click", () => {
                try {
                    this.validateOrThrow();
                } catch (error) {
                    this.showBlankPage();
                }
            });
        }

        showBlankPage() {
            // Tạo trang trắng che toàn bộ
            if (document.getElementById("lin-blank-overlay")) {
                return; // Đã tồn tại
            }

            const overlay = document.createElement("div");
            overlay.id = "lin-blank-overlay";
            overlay.style.cssText = `
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                background: white !important;
                z-index: 2147483647 !important;
                pointer-events: auto !important;
            `;

            // Thêm vào body hoặc html
            const target = document.body || document.documentElement;
            target.appendChild(overlay);

            // Vô hiệu hóa tương tác với trang
            if (document.body) {
                document.body.style.overflow = "hidden";
            }

            // Ngăn không cho xóa overlay
            this.protectOverlay(overlay);
        }

        protectOverlay(overlay) {
            // Tạo observer để ngăn việc xóa overlay
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === "childList") {
                        mutation.removedNodes.forEach((node) => {
                            if (node.id === "lin-blank-overlay") {
                                // Tạo lại overlay nếu bị xóa
                                setTimeout(() => this.showBlankPage(), 0);
                            }
                        });
                    }
                });
            });

            observer.observe(document.body || document.documentElement, {
                childList: true,
                subtree: true,
            });
        }

        isLicenseValid() {
            try {
                const expiry = new Date(this.expiryDate);
                const currentDate = new Date();
                expiry.setHours(23, 59, 59, 999);
                return currentDate <= expiry && this.isActivated;
            } catch (error) {
                return false;
            }
        }

        validateOrThrow() {
            if (!this.isLicenseValid()) {
                const error = new Error("License Expired");
                error.name = "LicenseExpiredError";
                error.code = "LIN_LICENSE_EXPIRED";
                error.details = {
                    expiredOn: this.expiryDate,
                    licenseKey: this.licenseKey,
                    message: "Your license has expired.",
                };
                throw error;
            }
            return true;
        }
    }

    const linManager = new LinLicenseManager();

    if (typeof window !== "undefined") {
        window.Lin = {
            check: () => linManager.isLicenseValid(),
            validateOrThrow: () => linManager.validateOrThrow(),
            manager: linManager,
        };
    }
})();
