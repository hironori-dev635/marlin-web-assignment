<template>
    <header class="bg-gray-100 md:flex md:items-center shadow">
        <h1 class="p-4 font-bold text-lg text-center md:w-64">
            アプリタイトル
        </h1>
        <button @click="toggleSidebar" class="p-4 border rounded">☰</button>
    </header>
    <div class="flex h-screen overflow-hidden relative">
        <!-- サイドバー -->
        <aside
            class="absolute top-0 left-0 w-64 bg-gray-800 text-white w-64 h-full flex-shrink-0"
            :class="[
                animate
                    ? sidebarOpen
                        ? 'translate-x-0 transition-transform duration-300'
                        : '-translate-x-64 transition-transform duration-300'
                    : initialSidebarClass, // ←画面描画前animateがfalseなのでこれが適応される
            ]"
        >
            <div class="p-4 font-bold">メニュー</div>
            <ul>
                <li>
                    <a href="/dashboard" class="hover:bg-gray-600 p-4 block">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/users" class="hover:bg-gray-600 p-4 block">
                        Users
                    </a>
                </li>

                <!-- Settings（アコーディオン） -->
                <li class="border-t border-gray-700">
                    <!-- 親メニュー部分 -->
                    <div
                        class="flex justify-between items-center p-4 hover:bg-gray-600 cursor-pointer"
                        :class="settingsOpen ? 'bg-gray-700' : ''"
                        @click="toggleSettings"
                    >
                        <span>Settings</span>

                        <!-- 矢印アイコン（右→下へ回転） -->
                        <svg
                            class="w-4 h-4 transition-transform duration-300"
                            :class="settingsOpen ? 'rotate-90' : 'rotate-0'"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </div>

                    <!-- アコーディオン部分 -->
                    <div
                        class="overflow-hidden transition-all duration-300 bg-gray-700"
                        :style="
                            settingsOpen
                                ? 'max-height: 400px; '
                                : 'max-height: 0; '
                        "
                    >
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a
                                    href="/settings/profile"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/settings/password"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Password
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/settings/notifications"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Notifications
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/settings/billing"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Billing
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/settings/security"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Security
                                </a>
                            </li>
                            <li>
                                <a
                                    href="/settings/export-data"
                                    class="hover:bg-gray-600 p-2 pl-6 block"
                                >
                                    Export Data
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="/price" class="hover:bg-gray-600 p-4 block">
                        Price
                    </a>
                </li>
            </ul>
        </aside>

        <!-- メインエリア -->
        <div
            class="flex-1 transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'"
        >
            <main class="p-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const sidebarOpen = ref();

const animate = ref(false); // アニメーションフラグ

const initialSidebarClass = ref("");

//画面描画前に実行
if (typeof window !== "undefined") {
    // window があるならブラウザだから OKってことで実行、安全策。
    if (window.innerWidth >= 768) {
        //幅広の時
        initialSidebarClass.value = "translate-x-0"; // 表示する位置に
        sidebarOpen.value = true;
    } else {
        initialSidebarClass.value = "-translate-x-64"; // 非表示の位置に
        sidebarOpen.value = false;
    }
}

const handleResize = () => {
    // 例: 768px 未満なら自動で閉じる
    sidebarOpen.value = window.innerWidth >= 768;
};

//↓↓画面描画後に１回実行
onMounted(() => {
    window.addEventListener("resize", handleResize);
    animate.value = true;
});

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

onUnmounted(() => {
    window.removeEventListener("resize", handleResize);
});

const settingsOpen = ref(false);

const toggleSettings = () => {
    settingsOpen.value = !settingsOpen.value;
};
</script>
