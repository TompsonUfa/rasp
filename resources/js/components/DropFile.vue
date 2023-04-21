<template>
    <div class="dropzone dropzone-container">
        <h1 class="dropzone__title">Загрузка расписания</h1>
        <input
            @change="this.handleFileUpload"
            type="file"
            name="files"
            multiple="multiple"
            id="fileInput"
            class="dropzone__hidden-input"
        />
        <label
            for="fileInput"
            class="dropzone__file-label"
            :class="this.isDragging ? 'dropzone__file-label_active' : null"
            @dragover="dragover"
            @dragleave="dragleave"
            @drop="drop"
        >
            <i class="bx bxs-cloud-upload"></i>
            <span v-if="this.isDragging == false"
                >Выбрать файл для загрузки</span
            >
            <span v-if="this.isDragging">Отпустите, чтобы загрузить файлы</span>
        </label>
        <div class="dropzone__files">
            <div v-for="file in files" class="dropzone__file file">
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
                        <div
                            class="progress"
                            :style="{ width: file.progress + '%' }"
                        ></div>
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
                const { data } = await axios.get("/import-status/" + file.uuid);
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
                await new Promise((resolve) => setTimeout(resolve, 1000)); // добавляем задержку, чтобы не перегружать сервер
            }
        },
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
        border: 2px dashed var(--button-color);
        border-radius: 12px;
        color: var(--button-color);
        font-size: 20px;
        margin-top: 40px;
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
        margin-top: 40px;
        &::-webkit-scrollbar {
            width: 0px;
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
        color: var(--button-color);
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
</style>
