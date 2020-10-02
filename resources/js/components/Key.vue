<template>
    <div class="outer-container">
        <page-header/>
        <v-container text-center fill-height>
            <v-row>
                <v-col cols="12">
                    <div id="p5-canvas"></div>
                    <p id="low-label" class="position-absolute">Low</p>
                    <p id="high-label" class="position-absolute">High</p>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
    import PageHeader from '@/js/components/Header';

    export default {
        mounted() {
            let key;
            let script;
            let angle = 0;

            script = function(sketch) {
                let slider;
                let width;

                if (sketch.windowWidth >= 768) {
                    width = sketch.windowWidth-(sketch.windowWidth*.5);
                } else {
                    width = sketch.windowWidth-80;
                }
                sketch.setup = _ => {
                    sketch.createCanvas(width, width);
                    sketch.angleMode(sketch.DEGREES);
                    slider = sketch.createSlider(0, 180, 0, 1);
                    slider.style('width', sketch.width + 'px');
                    slider.style('position', 'absolute');
                    slider.style('left', '50%')
                    slider.style('top', '100%')
                    slider.style('transform', 'translateX(-50%)')
                    slider.parent('p5-canvas');
                }

                sketch.draw = _=> {
                    sketch.background(255, 255, 255);
                    sketch.translate(sketch.width/2, sketch.height);
                    sketch.branch(sketch.width/3);
                    angle = slider.value() - 180;
                    let max = 100;
                    let colour = ((angle + 180)/max) * 255;
                    sketch.stroke(0, colour, 0);
                }

                sketch.branch = (len) => {
                    sketch.line(0, 0, 0, -len);
                    sketch.translate(0, -len);
                    if (len > 4) {
                        sketch.push();
                        sketch.rotate(angle);
                        sketch.branch(len * 0.6);
                        sketch.pop();
                        sketch.push();
                        sketch.rotate(-angle);
                        sketch.branch(len * 0.6);
                        sketch.pop();
                    }
                }
            }

            const p5 = require ('p5');

            key = new p5(script, 'p5-canvas');


        },
        components: {
            PageHeader
        }
    }
</script>

<style scoped>
    #p5-canvas {
        position: relative;
    }

    .position-absolute {
        transform: translateX(-50%);
    }

    #low-label {
        left: 10%;
    }

    #high-label {
        left: 90%;
    }

    .outer-container {
        height: calc(100% - 64px);
    }
    
    /*TODO Improve this*/
    @media (max-width: 426px) {
        #low-label {
            left: 5%;
        }
        #high-label {
            right: 95%;
        }
    }
</style>