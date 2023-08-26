<template>
    <div class="dropzone dropzone-container">
        <h1 class="dropzone__title">Загрузка расписания</h1>
        <input @change="this.handleFileUpload" type="file" name="files" multiple="multiple" id="fileInput"
            class="dropzone__hidden-input" />
        <div class="dropzone__filters">
            <div class="dropzone__wrap-filter" v-for="filter in filters" :key="filter.id">
                <input class="dropzone__filter" type="radio" :id="'filter' + filter.id" name="filter" :value=filter.value
                    :checked="activeFilter == 'false' && filter.id == 1" />
                <label :for="'filter' + filter.id">{{ filter.name }}</label>
                <div class="dropzone__filter-btn" @click="toggleFilters(filter)">
                    <svg height="64px" width="64px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310.277 310.277" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path style="fill:#010002;"
                                    d="M155.139,0C69.598,0,0,69.598,0,155.139c0,85.547,69.598,155.139,155.139,155.139 s155.139-69.592,155.139-155.139C310.283,69.592,240.686,0,155.139,0z M149.291,227.815c-7.309,0-12.322-5.639-12.322-12.948 c0-7.727,5.227-13.157,12.536-13.157c7.315,0,12.322,5.43,12.322,13.157C161.822,222.176,157.018,227.815,149.291,227.815z M169.549,149.494c-9.183,10.86-12.53,20.049-11.904,30.706l0.209,5.43h-16.29l-0.418-5.43 c-1.253-11.283,2.506-23.599,12.954-36.135c9.404-11.069,14.625-19.219,14.625-28.617c0-10.651-6.689-17.751-19.852-17.96 c-7.518,0-15.872,2.506-21.093,6.474l-5.012-13.157c6.892-5.012,18.796-8.354,29.87-8.354c24.023,0,34.882,14.828,34.882,30.706 C187.521,127.357,179.579,137.59,169.549,149.494z">
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="dropzone__filter-info" v-if="filter.open">
                    {{ filter.desc.name }}
                    <ul>
                        <li v-for="item in filter.desc.items">{{ item }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <label for="fileInput" class="dropzone__file-label" :class="this.isDragging ? 'dropzone__file-label_active' : null"
            @dragover="dragover" @dragleave="dragleave" @drop="drop">
            <i class="bx bxs-cloud-upload"></i>
            <span v-if="this.isDragging == false">Выбрать файл для загрузки</span>
            <span v-if="this.isDragging">Отпустите, чтобы загрузить файлы</span>
        </label>
        <div class="dropzone__files">
            <div v-for="   file    in    files   " :key="file.id" class="dropzone__file file">
                <i class="bx bxs-file"></i>
                <div class="file__info">
                    <div class="file__text">
                        <p class="file__name">{{ file.name }}</p>
                        <p class="file__percent" v-if="file.loaded == false">
                            {{ file.progress + "%" }}
                        </p>
                    </div>
                    <span v-if="file.loaded" class="file__size">{{
                        file.size + " КБ"
                    }}</span>
                    <div class="progress-bar" v-if="file.loaded == false">
                        <div class="progress" :style="{ width: file.progress + '%' }"></div>
                    </div>
                </div>
                <div class="file__status" v-if="file.loaded">
                    <i class="bx bx-check"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { uuid } from "vue3-uuid";
import axios from "axios";
export default {
    data() {
        return {
            files: [],
            filters: [
                {
                    id: 1, name: "Все листы", value: false, open: false, desc: { name: "Будут импортированны все листы файла.", items: ["Макс. 50 листов "] }
                },
                {
                    id: 2, name: "По фильтру", value: true, open: false, desc: { name: "Будут импортированны по следующим фильтрам:", items: ["Текущ. неделя: dd.mm - dd.mm.YYYY", "След. неделя: dd.mm - dd.mm.YYYY", "Лист с им. Активный"] }
                },
            ],
            activeFilter: "false",
            isDragging: false,
        };
    },
    methods: {
        dragover(e) {
            e.preventDefault();
            this.isDragging = true;
        },
        dragleave() {
            this.isDragging = false;
        },
        drop(e) {
            e.preventDefault();
            this.isDragging = false;
            this.handleFileUpload(e.dataTransfer);
        },
        handleFileUpload(event) {
            let files;
            if (event.target == undefined) {
                files = event.files;
            } else {
                files = event.target.files;
            }
            for (let i = 0; i < files.length; i++) {
                const fileObject = {
                    uuid: uuid.v4(),
                    name: files[i].name,
                    file: files[i],
                    size: Math.ceil(files[i].size / 1024),
                    progress: 0,
                    loaded: false,
                };
                this.files.push(fileObject);
            }
            this.submitFile();
        },
        async submitFile() {
            let self = this;
            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].loaded == false) {
                    let formData = new FormData();
                    formData.append("file", this.files[i].file);
                    formData.append("uuid", this.files[i].uuid);
                    formData.append("filter", this.activeFilter);
                    await axios
                        .post("/admin/create", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                            onUploadProgress: async () => {
                                await self.getData(this.files[i]);
                            },
                        })
                        .then((res) => {
                            console.log(res);
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                }
            }
        },
        async getData(file) {
            while (true) {
                const { data } = await axios.get(
                    "/admin/import-status/" + file.uuid
                );
                if (data.finished) {
                    file.progress = 100;
                    file.loaded = true;
                    break;
                }
                if (data.started) {
                    file.progress = Math.ceil(
                        (data.current_row / data.total_rows) * 100
                    );
                }
                await new Promise((resolve) => setTimeout(resolve, 1000));
            }
        },
        toggleFilters(selectFilter) {
            this.filters.forEach(filter => {
                if (filter == selectFilter) {
                    filter.open = !filter.open;
                } else {
                    filter.open = false;
                }
            });
        }
    },
};
</script>

<style lang="scss" scoped>
.dropzone-container {
    width: 100%;
    max-width: 650px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
}

.dropzone {
    position: relative;
    padding: 40px;
    overflow-y: auto;

    &__title {
        text-align: center;
    }

    &__hidden-input {
        display: none;
    }

    &__file-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 200px;
        border: 2px dashed var(--first-color-alt);
        border-radius: 12px;
        color: var(--first-color-alt);
        font-size: 20px;
        margin-top: 20px;
        transition: 0.4s ease;
        cursor: pointer;

        i {
            font-size: 60px;
        }

        &_active {
            background: rgba(0, 0, 0, 0.05);
        }
    }

    &__files {
        display: flex;
        flex-direction: column;
        max-height: 400px;
        overflow-y: auto;
        gap: 20px;
        margin-top: 20px;

        &::-webkit-scrollbar {
            width: 0px;
        }
    }

    &__filters {
        display: flex;
        gap: 20px;
        margin-top: 40px;
    }

    &__wrap-filter {
        position: relative;
        display: flex;
        align-items: center;
        gap: 7px;

        &:checked {
            color: red;
        }
    }

    &__filter-btn {
        width: 20px;
        height: 20px;
        opacity: 0.7;
        transition: all 0.3s ease;
        cursor: pointer;

        &:hover {
            opacity: 1;
        }

        svg {
            width: inherit;
            height: inherit;
        }
    }

    &__filter-info {
        position: absolute;
        top: 35px;
        left: 0;
        width: 300px;
        padding: 20px;
        border-radius: 5px;
        background-color: #212529;
        color: #fff;

        ul {
            padding-left: 20px;

            li {
                padding: 5px 0px;
            }
        }

    }
}

.file {
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 15px;
    background: rgba(0, 0, 0, 0.05);

    i {
        color: var(--first-color-alt);
        font-size: 40px;
    }

    &__info {
        width: 100%;
    }

    &__text {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 5px;
    }

    &__size {
        font-size: 13px;
        color: #404040;
    }

    &__status {
        i {
            font-size: 30px;
        }
    }
}

.progress-bar {
    width: 100%;
    height: 10px;
    background-color: #fff;
    border-radius: 10px;

    .progress {
        height: 100%;
        border-radius: 10px;
        transition: all 0.4s;
        background-color: var(--button-color);
    }
}

@media screen and (max-width: 550px) {
    .dropzone {
        padding: 20px;

        &__title {
            font-size: 25px;
        }

        &__file-label {
            font-size: 15px;
        }
    }
}
</style>
