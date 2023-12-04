import { FontSize } from "@/Constants/Style";

const rx_arr = [/(\()(.*?)(\))/, /(\*)(.*?)(\*)/, /(\~)(.*?)(\~)/]

const replacer = (match: string, p1: string, p2: string, p3: string, offset: Number, string: string) => {
    switch(`${p1}${p3}`) {
        case `()`:
            return `<span style="color: gray; font-size: ${FontSize[0]};">${p2}</span>`
        case `**`:
            return `<span style="color: red;"><em>${p2}</em></span>`
        case `~~`:
            return `<span style="color: blue;">${p2}</span>`
        default:
            return `${2}`
    }
}

const PlainToRich = (txt: string) => {
    for (let i = 0; i < rx_arr.length; i++){
        const re = rx_arr[i];
        let all_found = false;
        while (!all_found){
            txt = txt.replace(re, replacer)
            all_found = txt.search(re) === -1 ? true : false
        }
    }
    return txt
}

export default PlainToRich;