<template>
    <div class="result">
        <h2 class="result__title">Понедельник</h2>
        <table class="result__table">
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Предмет / Преподаватель</th>
                    <th>Тип занятия</th>
                    <th>Аудитория</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>8:30 - 10:05</td>
                    <td>
                        Лечебная физическая культура
                        <span>Клочков Р.А.</span>
                    </td>
                    <td>
                        Учебная практика <br />
                        Научно-исследовательская работа
                    </td>
                    <td>К1-8</td>
                </tr>
                <tr>
                    <td>12:30 - 14:05</td>
                    <td>
                        Информационная безопастность
                        <span>Клочков Р.А.</span>
                    </td>
                    <td>Лекция</td>
                    <td>К1-28</td>
                </tr>
            </tbody>
        </table>
        <h2 class="result__title">Вторник</h2>
        <table class="result__table">
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Предмет / Преподаватель</th>
                    <th>Тип занятия</th>
                    <th>Аудитория</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>8:30 - 10:05</td>
                    <td>
                        Лечебная физическая культура
                        <span>Клочков Р.А.</span>
                    </td>
                    <td>
                        Учебная практика <br />
                        Научно-исследовательская работа
                    </td>
                    <td>К1-8</td>
                </tr>
                <tr>
                    <td>12:30 - 14:05</td>
                    <td>
                        Информационная безопастность
                        <span>Клочков Р.А.</span>
                    </td>
                    <td>Лекция</td>
                    <td>К1-28</td>
                </tr>
                <tr>
                    <td>12:30 - 14:05</td>
                    <td>
                        Информационная безопастность
                        <span>Клочков Р.А.</span>
                    </td>
                    <td>Лекция</td>
                    <td>К1-28</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.result {
    &__title {
        text-align: center;
        letter-spacing: 1.7px;
    }
    &__table {
        width: 100%;
        margin: 30px 0px;
        border-collapse: collapse;
        border-radius: 15px;
        font-size: 17px;
        border-radius: 15px;
        &:last-child {
            margin-bottom: 0;
        }
        th {
            // border: 1px solid var(--text-color-light);
            color: var(--title-color);
            padding: 20px 15px;
        }
        tbody {
            tr:nth-child(odd) {
                background: rgba(0, 0, 0, 0.05);
            }
        }
        td {
            text-align: center;
            color: var(--text-color);
            // border: 1px solid var(--text-color-light);
            padding: 20px 15px;
            span {
                font-size: 16px;
                margin-top: 2px;
                display: block;
                color: #000;
                opacity: 0.7;
            }
        }
    }
}
.dark {
    .result {
        &__table {
            background: var(--body-color);
            td {
                color: var(--text-color);
                span {
                    color: inherit;
                }
            }
        }
    }
}
</style>
