## Steps to generate JSON translation prayer files for Prayer.Global

### Generate JSON files
* Navigate to https://prayer.global/build/json-generator
* Select the language you want to generate the JSON for and Click the "Generate JSON" button.
* Once it's finished generating them all and says 'Completed 4770' repeat the above step for another language
* OR click on 'generate all' if you want to regenerate all the languages
* The JSON files will be generated in /support/build/json-files/<language>/*.json

### Upload the JSON files to the R2 bucket
* go to a terminal on the machine that has the JSON files
* run the following command to upload the JSON files to the R2 bucket (note: you will need to adjust r2dt to match your config)
```
rclone copy /support/build/json-files r2dt:prayerglobal/json/
```
* This will upload the JSON files to the R2 bucket
* if you want to upload a specific language use the command
```
rclone copy /support/build/json-files/<language> r2dt:prayerglobal/json/<language>
