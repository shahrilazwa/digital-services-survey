export {};

declare global {
    interface Window {
        AppData?: {
            surveySchema: {
                id: number;
                schema_json: string;
            };
        };
    }
}
