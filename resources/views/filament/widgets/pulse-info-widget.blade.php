<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">
                <a
                    href="/pulse"
                    rel="noopener noreferrer"
                    target="_blank"
                    class="flex items-center gap-x-2"
                >
                    <svg width="24" height="23" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.4566 6.75005C15.9683 6.75596 16.4047 7.09621 16.5001 7.56364L18.8747 19.2038L19.999 17.1682C20.1832 16.8347 20.5526 16.625 20.9559 16.625H31.1744C31.7684 16.625 32.25 17.0727 32.25 17.625C32.25 18.1773 31.7684 18.625 31.1744 18.625H21.6127L19.3581 22.7068C19.1483 23.0867 18.7021 23.3008 18.2475 23.2397C17.7928 23.1786 17.4301 22.8559 17.3445 22.4363L15.376 12.7868L13.1334 22.4607C13.0282 22.9146 12.6007 23.2414 12.1013 23.2498C11.6019 23.2582 11.162 22.9458 11.0393 22.4957L9.30552 16.1378L8.19223 18.0929C8.00581 18.4202 7.64002 18.625 7.2416 18.625H1.32563C0.731576 18.625 0.25 18.1773 0.25 17.625C0.25 17.0727 0.731576 16.625 1.32563 16.625H6.59398L8.71114 12.9071C8.9193 12.5415 9.34805 12.3328 9.78979 12.3821C10.2315 12.4313 10.5951 12.7283 10.7044 13.1292L11.9971 17.8695L14.3918 7.53929C14.4996 7.07421 14.9449 6.74414 15.4566 6.75005Z" fill="url(#paint0_linear_4_31)"></path>
                        <defs>
                            <linearGradient id="paint0_linear_4_31" x1="16.25" y1="6.74997" x2="16.25" y2="23.25" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#F85A5A"></stop>
                                <stop offset="0.828125" stop-color="#7A5AF8"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                    <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Laravel Pulse
                    </h2>
                </a>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    {{ \Composer\InstalledVersions::getPrettyVersion('laravel/pulse') }}
                </p>
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link
                    color="gray"
                    href="https://laravel.com/docs/11.x/pulse"
                    icon="heroicon-m-book-open"
                    icon-alias="panels::widgets.filament-info.open-documentation-button"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    {{ __('filament-panels::widgets/filament-info-widget.actions.open_documentation.label') }}
                </x-filament::link>

                <x-filament::link
                    color="gray"
                    href="https://github.com/laravel/pulse"
                    icon-alias="panels::widgets.filament-info.open-github-button"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    <x-slot name="icon">
                        <svg
                            viewBox="0 0 98 96"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                clip-rule="evenodd"
                                fill="currentColor"
                                fill-rule="evenodd"
                                d="M48.854 0C21.839 0 0 22 0 49.217c0 21.756 13.993 40.172 33.405 46.69 2.427.49 3.316-1.059 3.316-2.362 0-1.141-.08-5.052-.08-9.127-13.59 2.934-16.42-5.867-16.42-5.867-2.184-5.704-5.42-7.17-5.42-7.17-4.448-3.015.324-3.015.324-3.015 4.934.326 7.523 5.052 7.523 5.052 4.367 7.496 11.404 5.378 14.235 4.074.404-3.178 1.699-5.378 3.074-6.6-10.839-1.141-22.243-5.378-22.243-24.283 0-5.378 1.94-9.778 5.014-13.2-.485-1.222-2.184-6.275.486-13.038 0 0 4.125-1.304 13.426 5.052a46.97 46.97 0 0 1 12.214-1.63c4.125 0 8.33.571 12.213 1.63 9.302-6.356 13.427-5.052 13.427-5.052 2.67 6.763.97 11.816.485 13.038 3.155 3.422 5.015 7.822 5.015 13.2 0 18.905-11.404 23.06-22.324 24.283 1.78 1.548 3.316 4.481 3.316 9.126 0 6.6-.08 11.897-.08 13.526 0 1.304.89 2.853 3.316 2.364 19.412-6.52 33.405-24.935 33.405-46.691C97.707 22 75.788 0 48.854 0z"
                            />
                        </svg>
                    </x-slot>

                    {{ __('filament-panels::widgets/filament-info-widget.actions.open_github.label') }}
                </x-filament::link>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
